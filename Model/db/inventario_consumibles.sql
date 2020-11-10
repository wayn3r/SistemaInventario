-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2020 a las 13:54:02
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_consumibles`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_cambiar_estado` (IN `_estado` VARCHAR(45), IN `_idEntrega` INT, IN `_idArticulo` INT, IN `_cantidad` INT)  BEGIN
	declare _idEstado int;
    declare _uso int;
	set _idEstado = (select e.idEstado from estado e where e.estado = _estado limit 1);
    SET SQL_SAFE_UPDATES=0;
    if(_idEstado is not null and _estado = 'en uso') then
		set _uso = (select e.idEstado from estado e where e.estado = 'activo' limit 1);
		update existencia e join existencia_entrega ee on e.idExistencia = ee.idExistencia 
		set e.idEstado = _idEstado where ee.idEntrega = _idEntrega and e.idEstado = _uso and e.idArticulo = _idArticulo  limit _cantidad;
        
   elseif(_idEstado is not null and _estado = 'activo') then
		set _uso = (select e.idEstado from estado e where e.estado = 'en uso' limit 1);
		update existencia e join existencia_entrega ee on e.idExistencia = ee.idExistencia 
        set e.idEstado = _idEstado where ee.idEntrega = _idEntrega and e.idEstado = _uso and e.idArticulo = _idArticulo limit _cantidad; 
    end if;
    SET SQL_SAFE_UPDATES=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_crear_detalle` (IN `idEntrega` INT, IN `idArt` INT, IN `cantidad` INT)  BEGIN
insert into existencia_entrega 
	select idEntrega, idExistencia from existencia e 
	join estado ed on e.idEstado = ed.idEstado 
	where e.idArticulo = idArt and ed.estado = 'activo' limit cantidad;

call proc_cambiar_estado('en uso',idEntrega, idArt, cantidad);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_crear_historico` ()  BEGIN
	declare idFecha int;
	insert into historico_fecha values(null,now());
    set idFecha = last_insert_id();
    if idFecha > 0 then
		insert into historico_impresora
			select null,idFecha ,i.* from vw_impresoras i;
		insert into historico_articulo
			select null,idFecha,a.* from vw_articulos a;
    end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_crear_notificar` (IN `id` INT)  BEGIN
	-- declarar todas las variables a utilizar  
    declare stock int;
    declare total int;
    declare model varchar(100);
    declare articulo varchar(50);
    
    -- buscando informacion del articulo pasado como parametro 
    set stock = (select cantidadStock from vw_articulos  where idArticulo = id limit 0,1);
    set total = (select cantidadContada from vw_articulos  where idArticulo = id limit 0,1);
    set model = (select modelo from vw_articulos  where idArticulo = id limit 0,1);
    set articulo = (select tipoArticulo from vw_articulos  where idArticulo = id limit 0,1);
    
    -- comprobando que existen los datos
    if stock is not null 
    and model is not null 
    and articulo is not null 
    and stock  < total/3 then
        insert into notificacion values(null, now(),articulo, model ,0,total, stock); -- creando notificiacion 
    end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_detalle` (IN `idEnt` INT, IN `idArt` INT, IN `cantidad` INT)  BEGIN
call proc_cambiar_estado('activo',idEnt, idArt, cantidad);
delete from existencia_entrega where idEntrega = idEnt and 
idExistencia in(
	select idExistencia from existencia e 
	where e.idArticulo = idArt)limit cantidad;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `idAcceso` int(11) NOT NULL,
  `controlador` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pagina` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`idAcceso`, `controlador`, `pagina`) VALUES
(1, 'Todos', 'todo'),
(2, 'Home', 'home.php'),
(3, 'Administracion', 'administracion.php'),
(4, 'Modelos', 'articulo.php'),
(5, 'Articulos', 'tipoarticulo.php'),
(6, 'Categorias', 'categoria.php'),
(7, 'Correos', 'correo.php'),
(8, 'Departamentos', 'departamento.php'),
(9, 'Detalles', 'detalle.php'),
(10, 'Empleados', 'empleado.php'),
(11, 'Entregas', 'entrega.php'),
(12, 'Existencias', 'existencia.php'),
(13, 'Historicos', 'historico.php'),
(14, 'Impresoras', 'impresora.php'),
(15, 'Marcas', 'marca.php'),
(16, 'Reporte', 'pdf.php'),
(17, 'Perfil', 'perfil.php'),
(18, 'Roles', 'rol.php'),
(19, 'Usuario', 'usuario.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idArticulo` int(11) NOT NULL,
  `idTipoArticulo` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL,
  `modelo` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `articulo`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_articulo` BEFORE DELETE ON `articulo` FOR EACH ROW begin
	delete from existencia where idArticulo = old.idArticulo;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `categoria`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_categoria` BEFORE DELETE ON `categoria` FOR EACH ROW begin
	delete from tipoarticulo where idCategoria = old.idCategoria;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correo`
--

CREATE TABLE `correo` (
  `idCorreo` int(11) NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `departamento`) VALUES
(1, 'Administración');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL,
  `codigoEmpleado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fechaEntrada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idDepartamento` int(11) NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `idEntrega` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `fechaEntrega` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `terminado` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `entrega`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_entrega` BEFORE DELETE ON `entrega` FOR EACH ROW begin
	declare _idEstado int;
    set _idEstado = (select e.idEstado from estado e where e.estado = 'activo' limit 1);    
    -- cambiaando los estados antes de eliminar los detalles 
	update existencia e join existencia_entrega ee on e.idExistencia = ee.idExistencia
    set e.idEstado = _idEstado where ee.idEntrega = old.idEntrega;
    
    -- eliminando detalles
    delete from existencia_entrega where idEntrega = old.idEntrega;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idEstado`, `estado`) VALUES
(1, 'activo'),
(3, 'en uso'),
(2, 'reparando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia`
--

CREATE TABLE `existencia` (
  `idExistencia` bigint(20) NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `fechaInventario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaCompra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `existencia`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_existencia` BEFORE DELETE ON `existencia` FOR EACH ROW begin
	call proc_crear_notificar (old.idArticulo);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_modificar_existencia` AFTER UPDATE ON `existencia` FOR EACH ROW begin
	if(new.idEstado != old.idEstado) then
		call proc_crear_notificar(new.idArticulo);
    end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia_entrega`
--

CREATE TABLE `existencia_entrega` (
  `idEntrega` int(11) NOT NULL,
  `idExistencia` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_articulo`
--

CREATE TABLE `historico_articulo` (
  `idHistorico` bigint(20) NOT NULL,
  `idFecha` int(11) NOT NULL,
  `fechaInventario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCompra` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idTipoArticulo` int(11) NOT NULL,
  `tipoArticulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idArticulo` int(11) NOT NULL,
  `modelo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idMarca` int(11) NOT NULL,
  `marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cantidadContada` bigint(20) NOT NULL,
  `cantidadStock` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_fecha`
--

CREATE TABLE `historico_fecha` (
  `idFecha` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_impresora`
--

CREATE TABLE `historico_impresora` (
  `idHistorico` bigint(20) NOT NULL,
  `idFecha` int(11) NOT NULL,
  `idImpresora` int(11) NOT NULL,
  `serialNumber` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccionIp` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInventario` date DEFAULT NULL,
  `fechaCompra` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idArticulo` int(11) DEFAULT NULL,
  `modelo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idTipoArticulo` int(11) NOT NULL,
  `tipoArticulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idMarca` int(11) NOT NULL,
  `marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresora`
--

CREATE TABLE `impresora` (
  `idImpresora` int(11) NOT NULL,
  `idArticulo` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL,
  `serialNumber` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccionIp` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInventario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaCompra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `impresora`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_impresora` AFTER DELETE ON `impresora` FOR EACH ROW begin
	call proc_crear_notificar (old.idArticulo);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `idLocalidad` int(11) NOT NULL,
  `localidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`idLocalidad`, `localidad`) VALUES
(1, 'Santo Domingo');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcaarticulo`
--

CREATE TABLE `marcaarticulo` (
  `idMarca` int(11) NOT NULL,
  `marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcaarticulo`
--

INSERT INTO `marcaarticulo` (`idMarca`, `marca`) VALUES
(1, 'Generico');

--
-- Disparadores `marcaarticulo`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_marca` BEFORE DELETE ON `marcaarticulo` FOR EACH ROW begin
	declare id int;
     set id = (select min(idMarca) from marcaarticulo where marca = 'Generico');
	update articulo set idMarca = id where idMarca = old.idMarca;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `idNotificacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipoArticulo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `modelo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `visto` bit(1) NOT NULL DEFAULT b'0',
  `total` int(11) DEFAULT NULL,
  `restante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idPerfil` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idLocalidad` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `nombre`, `apellido`, `correo`, `fechaCreacion`, `idLocalidad`, `idDepartamento`) VALUES
(1, 'Ron', 'Barceló', 'sistemainventariobarcelo@gmail.com', '2020-10-30', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--


CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rol`) VALUES
(1, 'Administrador'),
(3, 'Solo entregas'),
(4, 'Solo inventario'),
(2, 'Usuario');

--
-- Disparadores `rol`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_rol` BEFORE DELETE ON `rol` FOR EACH ROW begin
	delete from rol_acceso where idRol = old.idRol;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_acceso`
--

CREATE TABLE `rol_acceso` (
  `idRol` int(11) NOT NULL,
  `idAcceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol_acceso`
--

INSERT INTO `rol_acceso` (`idRol`, `idAcceso`) VALUES
(1, 1),
(3, 2),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 13),
(3, 16),
(3, 17),
(3, 19),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(4, 12),
(4, 14),
(4, 15),
(4, 17),
(4, 19),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoarticulo`
--

CREATE TABLE `tipoarticulo` (
  `idTipoArticulo` int(11) NOT NULL,
  `tipoArticulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `tipoarticulo`
--
DELIMITER $$
CREATE TRIGGER `tr_eliminar_tipoarticulo` BEFORE DELETE ON `tipoarticulo` FOR EACH ROW begin
	delete from articulo where idTipoArticulo = old.idTipoArticulo;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `toner_impresora`
--

CREATE TABLE `toner_impresora` (
  `idToner` int(11) NOT NULL,
  `idImpresora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `user` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `idPerfil` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `user`, `pass`, `idPerfil`, `idRol`) VALUES
(1, 'barcelo', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_accesos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_accesos` (
`idRol` int(11)
,`rol` varchar(50)
,`idAcceso` int(11)
,`controlador` varchar(50)
,`pagina` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_articulos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_articulos` (
`fechaInventario` varchar(10)
,`fechaCompra` varchar(10)
,`idCategoria` int(11)
,`categoria` varchar(50)
,`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
,`idArticulo` int(11)
,`modelo` varchar(100)
,`idMarca` int(11)
,`marca` varchar(100)
,`cantidadContada` bigint(22)
,`cantidadStock` bigint(22)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_categorias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_categorias` (
`idCategoria` int(11)
,`categoria` varchar(50)
,`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_detalles_entregas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_detalles_entregas` (
`idEntrega` int(11)
,`idExistencia` bigint(20)
,`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
,`idArticulo` int(11)
,`modelo` varchar(100)
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_empleados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_empleados` (
`idEmpleado` int(11)
,`codigoEmpleado` varchar(50)
,`nombre` varchar(50)
,`apellido` varchar(50)
,`correo` varchar(200)
,`fechaEntrada` date
,`idDepartamento` int(11)
,`activo` bit(1)
,`departamento` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_entregas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_entregas` (
`idEntrega` int(11)
,`recibidoPor` varchar(101)
,`idPerfil` int(11)
,`entregadoPor` varchar(201)
,`localidad` varchar(100)
,`idDepartamento` int(11)
,`departamento` varchar(100)
,`idEmpleado` int(11)
,`codigoEmpleado` varchar(50)
,`fechaEntrega` date
,`terminado` bit(1)
,`totalArticulos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_existencias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_existencias` (
`idExistencia` bigint(20)
,`idEstado` int(11)
,`estado` varchar(45)
,`fechaInventario` varchar(10)
,`fechaCompra` varchar(10)
,`idArticulo` int(11)
,`modelo` varchar(100)
,`idMarca` int(11)
,`marca` varchar(100)
,`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_impresoras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_impresoras` (
`idImpresora` int(11)
,`serialNumber` varchar(100)
,`direccionIp` varchar(45)
,`fechaInventario` date
,`fechaCompra` varchar(10)
,`idEstado` int(11)
,`estado` varchar(45)
,`idArticulo` int(11)
,`modelo` varchar(100)
,`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
,`idMarca` int(11)
,`marca` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_marcas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_marcas` (
`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
,`idArticulo` int(11)
,`modelo` varchar(100)
,`idMarca` int(11)
,`marca` varchar(100)
,`idCategoria` int(11)
,`categoria` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_reportes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_reportes` (
`filtro` varchar(8)
,`data` varchar(151)
,`fecha` date
,`cantidad` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_tipoarticulos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_tipoarticulos` (
`idTipoArticulo` int(11)
,`tipoArticulo` varchar(50)
,`idCategoria` int(11)
,`categoria` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_toner_impresora`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_toner_impresora` (
`idToner` int(11)
,`idImpresora` int(11)
,`idTipoArticulo` int(11)
,`idMarca` int(11)
,`modelo` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_usuarios` (
`idUsuario` int(11)
,`user` varchar(100)
,`idPerfil` int(11)
,`nombreCompleto` varchar(201)
,`idRol` int(11)
,`rol` varchar(50)
,`fechaCreacion` date
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_accesos`
--
DROP TABLE IF EXISTS `vw_accesos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_accesos`  AS  select `r`.`idRol` AS `idRol`,`r`.`rol` AS `rol`,`a`.`idAcceso` AS `idAcceso`,`a`.`controlador` AS `controlador`,`a`.`pagina` AS `pagina` from ((`rol` `r` left join `rol_acceso` `ra` on(`r`.`idRol` = `ra`.`idRol`)) left join `acceso` `a` on(`ra`.`idAcceso` = `a`.`idAcceso`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_articulos`
--
DROP TABLE IF EXISTS `vw_articulos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_articulos`  AS  select ifnull(ifnull(max(`e`.`fechaInventario`),max(`i`.`fechaInventario`)),'-') AS `fechaInventario`,ifnull(max(`e`.`fechaCompra`),ifnull(max(`i`.`fechaCompra`),'-')) AS `fechaCompra`,`c`.`idCategoria` AS `idCategoria`,`c`.`categoria` AS `categoria`,`ta`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo`,`a`.`idArticulo` AS `idArticulo`,`a`.`modelo` AS `modelo`,`ma`.`idMarca` AS `idMarca`,`ma`.`marca` AS `marca`,count(`e`.`idExistencia`) + ifnull(count(`i`.`idImpresora`),0) AS `cantidadContada`,ifnull(`stock`.`cantidadStock`,0) + ifnull(`stockimpresora`.`cantidadStock`,0) AS `cantidadStock` from (((((((`articulo` `a` left join `existencia` `e` on(`a`.`idArticulo` = `e`.`idArticulo`)) join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) join `marcaarticulo` `ma` on(`ma`.`idMarca` = `a`.`idMarca`)) join `categoria` `c` on(`ta`.`idCategoria` = `c`.`idCategoria`)) left join (select `e`.`idArticulo` AS `idArticulo`,count(`e`.`idExistencia`) AS `cantidadStock` from (`existencia` `e` join `estado` `ed` on(`e`.`idEstado` = `ed`.`idEstado`)) where `ed`.`estado` = 'activo' group by `e`.`idArticulo`) `stock` on(`e`.`idArticulo` = `stock`.`idArticulo`)) left join `impresora` `i` on(`a`.`idArticulo` = `i`.`idArticulo`)) left join (select `i`.`idArticulo` AS `idArticulo`,`i`.`fechaCompra` AS `fechaCompra`,count(`i`.`idImpresora`) AS `cantidadStock` from (`impresora` `i` join `estado` `ed` on(`i`.`idEstado` = `ed`.`idEstado`)) where `ed`.`estado` = 'activo' group by `i`.`idArticulo`) `stockimpresora` on(`a`.`idArticulo` = `stockimpresora`.`idArticulo`)) group by `a`.`idArticulo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_categorias`
--
DROP TABLE IF EXISTS `vw_categorias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_categorias`  AS  select `c`.`idCategoria` AS `idCategoria`,`c`.`categoria` AS `categoria`,`ta`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo` from (`categoria` `c` left join `tipoarticulo` `ta` on(`c`.`idCategoria` = `ta`.`idCategoria`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_detalles_entregas`
--
DROP TABLE IF EXISTS `vw_detalles_entregas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detalles_entregas`  AS  select `ee`.`idEntrega` AS `idEntrega`,`ee`.`idExistencia` AS `idExistencia`,`e`.`idTipoArticulo` AS `idTipoArticulo`,`e`.`tipoArticulo` AS `tipoArticulo`,`e`.`idArticulo` AS `idArticulo`,`e`.`modelo` AS `modelo`,count(`e`.`modelo`) AS `cantidad` from (`existencia_entrega` `ee` join `vw_existencias` `e` on(`ee`.`idExistencia` = `e`.`idExistencia`)) group by `ee`.`idEntrega`,`e`.`modelo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_empleados`
--
DROP TABLE IF EXISTS `vw_empleados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_empleados`  AS  select `e`.`idEmpleado` AS `idEmpleado`,`e`.`codigoEmpleado` AS `codigoEmpleado`,`e`.`nombre` AS `nombre`,`e`.`apellido` AS `apellido`,`e`.`correo` AS `correo`,`e`.`fechaEntrada` AS `fechaEntrada`,`e`.`idDepartamento` AS `idDepartamento`,`e`.`activo` AS `activo`,`d`.`departamento` AS `departamento` from (`empleado` `e` join `departamento` `d` on(`e`.`idDepartamento` = `d`.`idDepartamento`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_entregas`
--
DROP TABLE IF EXISTS `vw_entregas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_entregas`  AS  select `de`.`idEntrega` AS `idEntrega`,concat(`epd`.`nombre`,' ',`epd`.`apellido`) AS `recibidoPor`,`p`.`idPerfil` AS `idPerfil`,concat(`p`.`nombre`,' ',`p`.`apellido`) AS `entregadoPor`,`l`.`localidad` AS `localidad`,`d`.`idDepartamento` AS `idDepartamento`,`d`.`departamento` AS `departamento`,`epd`.`idEmpleado` AS `idEmpleado`,`epd`.`codigoEmpleado` AS `codigoEmpleado`,`de`.`fechaEntrega` AS `fechaEntrega`,`de`.`terminado` AS `terminado`,ifnull(count(`ee`.`idExistencia`),0) AS `totalArticulos` from (((((`entrega` `de` join `perfil` `p` on(`de`.`idPerfil` = `p`.`idPerfil`)) join `localidad` `l` on(`p`.`idLocalidad` = `l`.`idLocalidad`)) join `empleado` `epd` on(`de`.`idEmpleado` = `epd`.`idEmpleado`)) join `departamento` `d` on(`epd`.`idDepartamento` = `d`.`idDepartamento`)) left join `existencia_entrega` `ee` on(`de`.`idEntrega` = `ee`.`idEntrega`)) group by `de`.`idEntrega` order by `de`.`fechaEntrega` desc,`de`.`idEntrega` desc ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_existencias`
--
DROP TABLE IF EXISTS `vw_existencias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_existencias`  AS  select `e`.`idExistencia` AS `idExistencia`,`e`.`idEstado` AS `idEstado`,`ed`.`estado` AS `estado`,ifnull(`e`.`fechaInventario`,'-') AS `fechaInventario`,ifnull(`e`.`fechaCompra`,'-') AS `fechaCompra`,`a`.`idArticulo` AS `idArticulo`,`a`.`modelo` AS `modelo`,`ma`.`idMarca` AS `idMarca`,`ma`.`marca` AS `marca`,`ta`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo` from ((((`existencia` `e` join `estado` `ed` on(`e`.`idEstado` = `ed`.`idEstado`)) join `articulo` `a` on(`e`.`idArticulo` = `a`.`idArticulo`)) join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) join `marcaarticulo` `ma` on(`a`.`idMarca` = `ma`.`idMarca`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_impresoras`
--
DROP TABLE IF EXISTS `vw_impresoras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_impresoras`  AS  select `i`.`idImpresora` AS `idImpresora`,`i`.`serialNumber` AS `serialNumber`,`i`.`direccionIp` AS `direccionIp`,`i`.`fechaInventario` AS `fechaInventario`,ifnull(`i`.`fechaCompra`,'-') AS `fechaCompra`,`i`.`idEstado` AS `idEstado`,`e`.`estado` AS `estado`,`i`.`idArticulo` AS `idArticulo`,`a`.`modelo` AS `modelo`,`a`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo`,`a`.`idMarca` AS `idMarca`,`ma`.`marca` AS `marca` from ((((`impresora` `i` join `estado` `e` on(`i`.`idEstado` = `e`.`idEstado`)) join `articulo` `a` on(`i`.`idArticulo` = `a`.`idArticulo`)) join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) join `marcaarticulo` `ma` on(`ma`.`idMarca` = `a`.`idMarca`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_marcas`
--
DROP TABLE IF EXISTS `vw_marcas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_marcas`  AS  select `ta`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo`,`a`.`idArticulo` AS `idArticulo`,`a`.`modelo` AS `modelo`,`ma`.`idMarca` AS `idMarca`,`ma`.`marca` AS `marca`,`c`.`idCategoria` AS `idCategoria`,`c`.`categoria` AS `categoria` from (((`marcaarticulo` `ma` left join `articulo` `a` on(`ma`.`idMarca` = `a`.`idMarca`)) left join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) left join `categoria` `c` on(`ta`.`idCategoria` = `c`.`idCategoria`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_reportes`
--
DROP TABLE IF EXISTS `vw_reportes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_reportes`  AS  select 'articulo' AS `filtro`,concat(`ta`.`tipoArticulo`,' ',`a`.`modelo`) AS `data`,`e`.`fechaInventario` AS `fecha`,sum(`e`.`inventario`) AS `cantidad` from ((`articulo` `a` join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) join (select `existencia`.`idArticulo` AS `idArticulo`,`existencia`.`fechaInventario` AS `fechaInventario`,count(`existencia`.`idArticulo`) AS `inventario` from `existencia` group by `existencia`.`fechaInventario`) `e` on(`a`.`idArticulo` = `e`.`idArticulo`)) group by `e`.`fechaInventario`,`a`.`idArticulo` union select 'entrega' AS `filtro`,`d`.`departamento` AS `departamento`,`e`.`fechaEntrega` AS `mes`,count(`e`.`idEntrega`) AS `entrega` from ((`departamento` `d` join `empleado` `epd` on(`d`.`idDepartamento` = `epd`.`idDepartamento`)) join `entrega` `e` on(`epd`.`idEmpleado` = `e`.`idEmpleado`)) group by `e`.`fechaEntrega`,`d`.`idDepartamento` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_tipoarticulos`
--
DROP TABLE IF EXISTS `vw_tipoarticulos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tipoarticulos`  AS  select `ta`.`idTipoArticulo` AS `idTipoArticulo`,`ta`.`tipoArticulo` AS `tipoArticulo`,`c`.`idCategoria` AS `idCategoria`,`c`.`categoria` AS `categoria` from (`tipoarticulo` `ta` join `categoria` `c` on(`ta`.`idCategoria` = `c`.`idCategoria`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_toner_impresora`
--
DROP TABLE IF EXISTS `vw_toner_impresora`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_toner_impresora`  AS  select `a`.`idArticulo` AS `idToner`,`ti`.`idImpresora` AS `idImpresora`,`a`.`idTipoArticulo` AS `idTipoArticulo`,`a`.`idMarca` AS `idMarca`,`a`.`modelo` AS `modelo` from ((`articulo` `a` left join `toner_impresora` `ti` on(`ti`.`idToner` = `a`.`idArticulo`)) join `tipoarticulo` `ta` on(`a`.`idTipoArticulo` = `ta`.`idTipoArticulo`)) where `ta`.`tipoArticulo` = 'toner' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_usuarios`
--
DROP TABLE IF EXISTS `vw_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuarios`  AS  select `u`.`idUsuario` AS `idUsuario`,`u`.`user` AS `user`,`u`.`idPerfil` AS `idPerfil`,concat(`p`.`nombre`,' ',`p`.`apellido`) AS `nombreCompleto`,`u`.`idRol` AS `idRol`,`r`.`rol` AS `rol`,`p`.`fechaCreacion` AS `fechaCreacion` from ((`usuario` `u` join `perfil` `p` on(`u`.`idPerfil` = `p`.`idPerfil`)) join `rol` `r` on(`u`.`idRol` = `r`.`idRol`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`idAcceso`);

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idArticulo`),
  ADD KEY `fk_tipoarticulo_articulo_idx` (`idTipoArticulo`),
  ADD KEY `fk_marcaarticulo_articulo_idx` (`idMarca`);
  ADD UNIQUE KEY `modelo_UNIQUE` (`modelo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD UNIQUE KEY `categoria_UNIQUE` (`categoria`);

--
-- Indices de la tabla `correo`
--
ALTER TABLE `correo`
  ADD PRIMARY KEY (`idCorreo`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`),
  ADD UNIQUE KEY `departamento_UNIQUE` (`departamento`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD UNIQUE KEY `empleadocol_UNIQUE` (`codigoEmpleado`),
  ADD KEY `fk_departamento_empleado_idx` (`idDepartamento`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`idEntrega`),
  ADD KEY `f_empleado_entrega_idx` (`idEmpleado`),
  ADD KEY `fk_perfil_entrega_idx` (`idPerfil`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idEstado`),
  ADD UNIQUE KEY `estado_UNIQUE` (`estado`);

--
-- Indices de la tabla `existencia`
--
ALTER TABLE `existencia`
  ADD PRIMARY KEY (`idExistencia`),
  ADD KEY `fk_articulo_existencia_idx` (`idArticulo`),
  ADD KEY `fk_estado_existencia_idx` (`idEstado`);

--
-- Indices de la tabla `existencia_entrega`
--
ALTER TABLE `existencia_entrega`
  ADD PRIMARY KEY (`idEntrega`,`idExistencia`),
  ADD KEY `fk_existencias_entrega_idx` (`idExistencia`);

--
-- Indices de la tabla `historico_articulo`
--
ALTER TABLE `historico_articulo`
  ADD PRIMARY KEY (`idHistorico`),
  ADD KEY `fk_fecha_historico_articulo_idx` (`idFecha`);

--
-- Indices de la tabla `historico_fecha`
--
ALTER TABLE `historico_fecha`
  ADD PRIMARY KEY (`idFecha`),
  ADD UNIQUE KEY `fecha_UNIQUE` (`fecha`);

--
-- Indices de la tabla `historico_impresora`
--
ALTER TABLE `historico_impresora`
  ADD PRIMARY KEY (`idHistorico`),
  ADD KEY `fk_fecha_historico_impresora_idx` (`idFecha`);

--
-- Indices de la tabla `impresora`
--
ALTER TABLE `impresora`
  ADD PRIMARY KEY (`idImpresora`),
  ADD UNIQUE KEY `serialNumber_UNIQUE` (`serialNumber`),
  ADD KEY `fk_articulo_impresora_idx` (`idArticulo`),
  ADD KEY `fk_estado_impresora_idx` (`idEstado`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`idLocalidad`),
  ADD UNIQUE KEY `localidad_UNIQUE` (`localidad`);

--
-- Indices de la tabla `marcaarticulo`
--
ALTER TABLE `marcaarticulo`
  ADD PRIMARY KEY (`idMarca`),
  ADD UNIQUE KEY `marca_UNIQUE` (`marca`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`idNotificacion`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idPerfil`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD KEY `fk_localidad_perfil_idx` (`idLocalidad`),
  ADD KEY `fk_deparmento_perfil_idx` (`idDepartamento`);

--
--
--

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `rol_UNIQUE` (`rol`);

--
-- Indices de la tabla `rol_acceso`
--
ALTER TABLE `rol_acceso`
  ADD PRIMARY KEY (`idRol`,`idAcceso`),
  ADD KEY `fk_acceso_rolAcceso_idx` (`idAcceso`);

--
-- Indices de la tabla `tipoarticulo`
--
ALTER TABLE `tipoarticulo`
  ADD PRIMARY KEY (`idTipoArticulo`),
  ADD KEY `categoria_tipoconsumible` (`idCategoria`);

--
-- Indices de la tabla `toner_impresora`
--
ALTER TABLE `toner_impresora`
  ADD PRIMARY KEY (`idToner`,`idImpresora`),
  ADD KEY `fk_articulo_impresora_idx` (`idImpresora`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `user_UNIQUE` (`user`),
  ADD UNIQUE KEY `idPerfil_UNIQUE` (`idPerfil`),
  ADD KEY `fk_rol_usuario_idx` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
  MODIFY `idAcceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idArticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `correo`
--
ALTER TABLE `correo`
  MODIFY `idCorreo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `idEntrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `existencia`
--
ALTER TABLE `existencia`
  MODIFY `idExistencia` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `historico_articulo`
--
ALTER TABLE `historico_articulo`
  MODIFY `idHistorico` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `historico_fecha`
--
ALTER TABLE `historico_fecha`
  MODIFY `idFecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `historico_impresora`
--
ALTER TABLE `historico_impresora`
  MODIFY `idHistorico` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `impresora`
--
ALTER TABLE `impresora`
  MODIFY `idImpresora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `idLocalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcaarticulo`
--
ALTER TABLE `marcaarticulo`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `idNotificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipoarticulo`
--
ALTER TABLE `tipoarticulo`
  MODIFY `idTipoArticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_marcaarticulo_articulo` FOREIGN KEY (`idMarca`) REFERENCES `marcaarticulo` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipoarticulo_articulo` FOREIGN KEY (`idTipoArticulo`) REFERENCES `tipoarticulo` (`idTipoArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_departamento_empleado` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD CONSTRAINT `fk_empleado_entrega` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfil_entrega` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `existencia`
--
ALTER TABLE `existencia`
  ADD CONSTRAINT `fk_articulo_existencia` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estado_existencia` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `existencia_entrega`
--
ALTER TABLE `existencia_entrega`
  ADD CONSTRAINT `fk_entrega_existencia` FOREIGN KEY (`idEntrega`) REFERENCES `entrega` (`idEntrega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_existencias_entrega` FOREIGN KEY (`idExistencia`) REFERENCES `existencia` (`idExistencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historico_articulo`
--
ALTER TABLE `historico_articulo`
  ADD CONSTRAINT `fk_fecha_historico_articulo` FOREIGN KEY (`idFecha`) REFERENCES `historico_fecha` (`idFecha`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historico_impresora`
--
ALTER TABLE `historico_impresora`
  ADD CONSTRAINT `fk_fecha_historico_impresora` FOREIGN KEY (`idFecha`) REFERENCES `historico_fecha` (`idFecha`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `impresora`
--
ALTER TABLE `impresora`
  ADD CONSTRAINT `fk_articulo_impresora` FOREIGN KEY (`idArticulo`) REFERENCES `articulo` (`idArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estado_impresora` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `fk_deparmento_perfil` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_localidad_perfil` FOREIGN KEY (`idLocalidad`) REFERENCES `localidad` (`idLocalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_acceso`
--
ALTER TABLE `rol_acceso`
  ADD CONSTRAINT `fk_acceso_rolAcceso` FOREIGN KEY (`idAcceso`) REFERENCES `acceso` (`idAcceso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_rolAcceso` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tipoarticulo`
--
ALTER TABLE `tipoarticulo`
  ADD CONSTRAINT `fk_categoria_tipoarticulo` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `toner_impresora`
--
ALTER TABLE `toner_impresora`
  ADD CONSTRAINT `fk_impresora_articulo` FOREIGN KEY (`idImpresora`) REFERENCES `articulo` (`idArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_toner_articulo` FOREIGN KEY (`idToner`) REFERENCES `articulo` (`idArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_perfil_usuario` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_usuario` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
