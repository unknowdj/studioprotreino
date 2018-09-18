-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: robb0441.publiccloud.com.br:3306
-- Tempo de geração: 11/06/2018 às 13:20
-- Versão do servidor: 5.6.35-81.0-log
-- Versão do PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `romarioandre_site`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `complementary_material`
--

CREATE TABLE `complementary_material` (
  `id` int(11) NOT NULL,
  `signature_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `complementary_material`
--

INSERT INTO `complementary_material` (`id`, `signature_id`, `movie_id`, `training_id`) VALUES
(3, 1, 1, NULL),
(4, 1, NULL, 1),
(5, 1, NULL, 4),
(21, 3, 1, NULL),
(22, 3, NULL, 1),
(23, 3, NULL, 4),
(24, 3, NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `height` decimal(10,3) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `age`, `height`, `active`, `create_at`, `update_at`) VALUES
(1, 'Rafael Silva', 'contato@pantoneweb.com.br', '$2y$10$/S76udnabg1zkm11mQmUSeLF8DvPM2cQgxUMdCRKjBKU.Hskzj1ei', 30, '66.000', 1, '2017-02-01 03:29:27', '2017-02-01 03:29:27'),
(2, 'Treino 1', 'contato@pantoneweb.com.brt', '$2y$10$xitMF7AHFdjP3quQB9oD5eyo91l1ZPgisFRzxVXM0CKBhuGxUAUy6', 23, '9999999.999', 0, '2017-02-09 17:35:16', '2017-02-09 17:35:16'),
(3, 'Jose', 'jose@teste.com.br', '123456', 60, '101.000', 1, '2017-02-10 18:06:13', '2017-02-10 18:06:13'),
(4, 'Romário André Messias Pinto', 'romarioandre@hotmail.com', '$2y$10$LpSHDex2YH9ZPDi0KQ4nfOkCXKNYc87740XHEsRc0RRQfqrJ1v5m2', 28, '94.000', 1, '2017-03-06 19:09:32', '2017-03-06 19:09:32'),
(5, 'Marcel Jean Pierre Masse Araya', 'm.massea@gmail.com', 'cachipun2930', 25, '79.000', 1, '2017-05-09 16:01:45', '2017-05-09 16:01:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `embed` varchar(500) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `embed`, `active`, `create_at`, `update_at`) VALUES
(1, 'Treino de pernas', 'Faça o exercício 3 vezes por semana', 'https://www.youtube.com/watch?v=wK3MCwoY3K4', 1, '2017-02-01 03:25:00', '2017-02-01 03:25:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `physical_evaluations`
--

CREATE TABLE `physical_evaluations` (
  `id` int(11) NOT NULL,
  `signature_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `weight` decimal(15,2) NOT NULL,
  `fat_porcentage` decimal(15,2) NOT NULL,
  `muscle_mass_porcentage` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `physical_evaluations`
--

INSERT INTO `physical_evaluations` (`id`, `signature_id`, `date`, `weight`, `fat_porcentage`, `muscle_mass_porcentage`) VALUES
(1, 1, '2017-02-09 00:00:00', '65.00', '10.00', '90.00'),
(2, 1, '2017-02-08 00:00:00', '63.00', '26.00', '15.00'),
(3, 1, '2017-02-09 00:00:00', '15.00', '4.00', '5.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `plans`
--

INSERT INTO `plans` (`id`, `category_id`, `title`, `description`, `value`, `active`, `create_at`, `update_at`) VALUES
(1, 2, 'Plano 1', 'Esse plano é para teste', '0.00', 1, '2017-02-01 03:24:07', '2017-02-01 03:24:07'),
(2, 2, 'Plano 2', 'Teste', '15.53', 1, '2017-03-02 13:10:14', '2017-03-02 13:10:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plan_categories`
--

CREATE TABLE `plan_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `plan_categories`
--

INSERT INTO `plan_categories` (`id`, `name`) VALUES
(2, 'Consultoria'),
(1, 'Treinamento no estúdio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `signature`
--

CREATE TABLE `signature` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_initial` date NOT NULL,
  `date_end` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `value` decimal(15,2) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `signature`
--

INSERT INTO `signature` (`id`, `plan_id`, `customer_id`, `date_initial`, `date_end`, `active`, `value`, `create_at`, `update_at`) VALUES
(1, 1, 1, '2017-02-01', '2017-02-28', 1, '0.00', '2017-02-23 14:01:41', '2017-02-23 14:01:41'),
(2, 2, 3, '2017-02-10', '2017-02-10', 0, '15.53', '2017-02-10 18:06:13', '2017-02-10 18:06:13'),
(3, 1, 4, '2017-03-02', '2017-04-03', 1, '0.00', '2017-03-06 19:12:54', '2017-03-06 19:12:54'),
(4, 1, 5, '2017-05-09', '2017-05-09', 0, '0.00', '2017-05-09 16:01:45', '2017-05-09 16:01:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `training_id` int(11) DEFAULT NULL,
  `title` varchar(45) NOT NULL,
  `description` text,
  `series` text,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `trainings`
--

INSERT INTO `trainings` (`id`, `training_id`, `title`, `description`, `series`, `active`) VALUES
(1, NULL, 'Preparação de Movimento', 'Faça o exercício 4 vezes por semana.', '[]', 1),
(2, 1, 'Ponte | Ativação Adutor', 'If you\'re using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.\r\n\r\nIf you\'re creating controls with no other text (such as a  that only contains an icon), you should always provide alternative content to identify the purpose of the control, so that it will make sense to users of assistive technologies. In this case, you could add an aria-label attribute on the control itself.', '[{\"phase\":\"1\",\"week\":\"1\",\"charge\":\"10s\",\"repetition\":\"10\"},{\"phase\":\"1\",\"week\":\"2\",\"charge\":\"10s\",\"repetition\":\"10\"},{\"phase\":\"1\",\"week\":\"3\",\"charge\":\"10s\",\"repetition\":\"10\"},{\"phase\":\"1\",\"week\":\"4\",\"charge\":\"10s\",\"repetition\":\"10\"}]', 1),
(3, 1, 'Exercício Filho 2', NULL, '[{\"phase\":\"1\",\"week\":\"1\",\"charge\":\"10s\",\"repetition\":\"-\"},{\"phase\":\"1\",\"week\":\"2\",\"charge\":\"10s\",\"repetition\":\"-\"},{\"phase\":\"1\",\"week\":\"3\",\"charge\":\"10s\",\"repetition\":\"3x10\"},{\"phase\":\"1\",\"week\":\"4\",\"charge\":\"10s\",\"repetition\":\"10\"}]', 1),
(4, NULL, 'Treino 2', 'teste', NULL, 1),
(5, 4, 'exer 2', NULL, '[{\"phase\":\"2\",\"week\":\"1\",\"charge\":\"10\",\"repetition\":\"12\"}]', 1),
(6, NULL, 'Circuito Cardiovascular', '4x Escada 2 tempos frontal\r\n25 batidas corda alternados\r\n12 batidas slamball peitoral\r\n10 subidas na caixa c/ perna \r\n* Realizar o circuito 5 vezes', '[]', 1),
(9, 6, 'Circuito', 'Escada\r\ncorda\r\nSlamball\r\nCaixa', '[{\"phase\":\"1\",\"week\":\"1\",\"charge\":\"1\",\"repetition\":\"4\"}]', 1),
(10, 1, 'Preparação de movimentos', 'Mobilidade do Pé - Elevação do dedão\r\nMobilidade de Tornozelo - Flexão/Extensão de tornozelo na parede\r\nMobilidade de Ombro - Rotação do braço na parede', '[{\"phase\":\"1\",\"week\":\"1\",\"charge\":\"0\",\"repetition\":\"10\"}]', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`) VALUES
(1, 'Admin', 'admin', '$2y$10$cNHlk6K/gmSsTQPxeMeIuutXdIhTzHkaQ9OMdJMwfpcD46zocpE7u');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `complementary_material`
--
ALTER TABLE `complementary_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_complementary_material_movies1_idx` (`movie_id`),
  ADD KEY `fk_complementary_material_signature1_idx` (`signature_id`),
  ADD KEY `fk_complementary_material_trainings1_idx` (`training_id`);

--
-- Índices de tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Índices de tabela `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `physical_evaluations`
--
ALTER TABLE `physical_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_physical_evaluations_signature1_idx` (`signature_id`);

--
-- Índices de tabela `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_plans_plan_categories1_idx` (`category_id`);

--
-- Índices de tabela `plan_categories`
--
ALTER TABLE `plan_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `namer_UNIQUE` (`name`);

--
-- Índices de tabela `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_contract_active` (`plan_id`,`customer_id`,`active`),
  ADD KEY `fk_signature_plans1_idx` (`plan_id`),
  ADD KEY `fk_signature_customers1_idx` (`customer_id`);

--
-- Índices de tabela `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainingscol_UNIQUE` (`title`),
  ADD KEY `fk_trainings_trainings1_idx` (`training_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_UNIQUE` (`user`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `complementary_material`
--
ALTER TABLE `complementary_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `physical_evaluations`
--
ALTER TABLE `physical_evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `plan_categories`
--
ALTER TABLE `plan_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `complementary_material`
--
ALTER TABLE `complementary_material`
  ADD CONSTRAINT `fk_complementary_material_movies1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_complementary_material_signature1` FOREIGN KEY (`signature_id`) REFERENCES `signature` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_complementary_material_trainings1` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `physical_evaluations`
--
ALTER TABLE `physical_evaluations`
  ADD CONSTRAINT `fk_physical_evaluations_signature1` FOREIGN KEY (`signature_id`) REFERENCES `signature` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `fk_plans_plan_categories1` FOREIGN KEY (`category_id`) REFERENCES `plan_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `signature`
--
ALTER TABLE `signature`
  ADD CONSTRAINT `fk_signature_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_signature_plans1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `fk_trainings_trainings1` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
