--
-- Volcado de datos para la tabla `acceso`
--

INSERT IGNORE INTO `acceso` (`idAcceso`, `controlador`, `pagina`) VALUES
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
(16, 'PDFs', 'pdf.php'),
(17, 'Perfil', 'perfil.php'),
(18, 'Roles', 'rol.php'),
(19, 'Usuario', 'usuario.php'),
(20, 'Reporte', 'reporte.php');

-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `departamento`
--

INSERT IGNORE INTO `departamento` (`idDepartamento`, `departamento`) VALUES
(1, 'Administracion'),
(3, 'Contabilidad'),
(4, 'Recursos humanos'),
(2, 'Tecnologias de la informacion');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `estado`
--

INSERT IGNORE INTO `estado` (`idEstado`, `estado`) VALUES
(1, 'activo'),
(3, 'en uso'),
(2, 'reparando');


--
-- Volcado de datos para la tabla `localidad`
--

INSERT IGNORE INTO `localidad` (`idLocalidad`, `localidad`) VALUES
(3, 'San Cristobal'),
(2, 'San Francisco'),
(4, 'Santiago'),
(1, 'Santo Domingo');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `marcaarticulo`
--

INSERT IGNORE INTO `marcaarticulo` (`idMarca`, `marca`) VALUES
(3, 'DELL'),
(1, 'Generico'),
(4, 'Lenovo'),
(2, 'Logitech');


--
-- Volcado de datos para la tabla `perfil`
--

INSERT IGNORE INTO `perfil` (`idPerfil`, `nombre`, `apellido`, `correo`, `fechaCreacion`, `idLocalidad`, `idDepartamento`) VALUES
(1, 'Ron', 'Barcelo', 'sistemainventariobarcelo@gmail.com', '2020-10-30 00:00:00', 1, 1),
(2, 'Usuario', 'Prueba', 'usuario@prueba', '2021-03-30 00:00:00', 2, 2),
(3, 'Admin', 'Prueba', 'admin@prueba', '2021-03-30 00:00:00', 3, 1),
(8, 'Solo', 'Entregas', 'entregas@prueba', '2021-03-30 00:00:00', 4, 4),
(9, 'Solo', 'Inventario', 'inventario@prueba', '2021-03-30 00:00:00', 1, 2);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `rol`
--

INSERT IGNORE INTO `rol` (`idRol`, `rol`) VALUES
(1, 'Administrador'),
(3, 'Solo entregas'),
(4, 'Solo inventario'),
(2, 'Usuario');

--
-- Volcado de datos para la tabla `rol_acceso`
--

INSERT IGNORE INTO `rol_acceso` (`idRol`, `idAcceso`) VALUES
(1, 1),
(2, 1),
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
(3, 20),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(4, 12),
(4, 14),
(4, 15),
(4, 17),
(4, 19),
(4, 20);

--
-- Volcado de datos para la tabla `usuario`
--

INSERT IGNORE INTO `usuario` (`idUsuario`, `user`, `pass`, `idPerfil`, `idRol`) VALUES
(1, 'barcelo', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1),
(2, 'usuario', 'f8032d5cae3de20fcec887f395ec9a6a', 2, 2),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 3, 1),
(8, 'entregas', '94c89aafa1a66c31d193276261345581', 8, 3),
(9, 'inventario', '61a892b8d073f99d98af5de82be351e7', 9, 4);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `categoria`
--

INSERT IGNORE INTO `categoria` (`idCategoria`, `categoria`) VALUES
(2, 'Equipos de oficina'),
(1, 'Perifericos');

--
-- Volcado de datos para la tabla `tipoarticulo`
--

INSERT IGNORE INTO `tipoarticulo` (`idTipoArticulo`, `tipoArticulo`, `idCategoria`) VALUES
(1, 'Impresora', 2),
(2, 'Toner', 2),
(3, 'Mouse', 1),
(4, 'Teclado', 1),
(5, 'Camara web', 1),
(6, 'Monitor', 1),
(7, 'Headset', 1);

--
-- Volcado de datos para la tabla `articulo`
--

INSERT IGNORE INTO `articulo` (`idArticulo`, `idTipoArticulo`, `idMarca`, `modelo`) VALUES
(1, 1, 2, 'IMPRESORA-PRUEBA-1000'),
(2, 2, 1, 'RGB-PRUEBA'),
(3, 3, 2, 'PRUEBA'),
(4, 4, 1, '123PRUEBA'),
(5, 6, 4, 'MONITORES-PRUEBA'),
(6, 5, 1, 'rgv123'),
(7, 7, 2, 'headset');

--
-- Volcado de datos para la tabla `empleado`
--

INSERT IGNORE INTO `empleado` (`idEmpleado`, `codigoEmpleado`, `nombre`, `apellido`, `correo`, `fechaEntrada`, `idDepartamento`, `activo`) VALUES
(1, '1234', 'Empleado', 'Prueba', 'empleado@prueba', '2021-03-30 17:01:23', 3, b'1'),
(2, '4321', 'Empleado', 'Prueba 2', 'empleado@prueba2', '2021-03-30 17:04:01', 1, b'1');

-- --

--
-- Volcado de datos para la tabla `entrega`
--

INSERT IGNORE INTO `entrega` (`idEntrega`, `idPerfil`, `idEmpleado`, `fechaEntrega`, `terminado`) VALUES
(1, 3, 1, '2021-03-30 17:01:46', b'1'),
(2, 3, 2, '2021-03-30 17:04:11', b'1');

--
-- Volcado de datos para la tabla `existencia`
--

INSERT IGNORE INTO `existencia` (`idExistencia`, `idArticulo`, `idEstado`, `fechaInventario`, `fechaCompra`) VALUES
(1, 2, 3, '2021-03-30 16:45:57', '2021-03-30'),
(2, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(3, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(4, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(5, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(6, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(7, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(8, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(9, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(10, 2, 1, '2021-03-30 16:45:57', '2021-03-30'),
(11, 3, 3, '2021-03-30 16:51:04', '2021-03-30'),
(12, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(13, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(14, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(15, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(16, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(17, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(18, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(19, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(20, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(21, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(22, 3, 1, '2021-03-30 16:51:04', '2021-03-30'),
(23, 4, 3, '2021-03-30 16:51:41', '2021-03-30'),
(24, 4, 3, '2021-03-30 16:51:41', '2021-03-30'),
(25, 4, 3, '2021-03-30 16:51:41', '2021-03-30'),
(26, 4, 3, '2021-03-30 16:51:41', '2021-03-30'),
(27, 5, 2, '2021-03-30 16:52:23', '2021-03-30'),
(28, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(29, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(30, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(31, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(32, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(33, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(34, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(35, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(36, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(37, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(38, 6, 3, '2021-03-30 16:52:53', '2021-03-30'),
(39, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(40, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(41, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(42, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(43, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(44, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(45, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(46, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(47, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(48, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(49, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(50, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(51, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(52, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(53, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(54, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(55, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(56, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(57, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(58, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(59, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(60, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(61, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(62, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(63, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(64, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(65, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(66, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(67, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(68, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(69, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(70, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(71, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(72, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(73, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(74, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(75, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(76, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(77, 6, 1, '2021-03-30 16:52:53', '2021-03-30'),
(78, 7, 3, '2021-03-30 16:53:29', '2021-03-30'),
(79, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(80, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(81, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(82, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(83, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(84, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(85, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(86, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(87, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(88, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(89, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(90, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(91, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(92, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(93, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(94, 7, 1, '2021-03-30 16:53:29', '2021-03-30'),
(95, 7, 1, '2021-03-30 16:53:29', '2021-03-30');


--
-- Volcado de datos para la tabla `existencia_entrega`
--

INSERT IGNORE INTO `existencia_entrega` (`idEntrega`, `idExistencia`) VALUES
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 78),
(2, 1),
(2, 11);

-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `impresora`
--

INSERT IGNORE INTO `impresora` (`idImpresora`, `idArticulo`, `idEstado`, `serialNumber`, `direccionIp`, `fechaInventario`, `fechaCompra`) VALUES
(1, 1, 1, '21ABPRUEBA', '192.168.1.10', '2021-03-30 16:44:45', '2021-03-30');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `toner_impresora`
--

INSERT IGNORE INTO `toner_impresora` (`idToner`, `idImpresora`) VALUES
(2, 1);
