-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 26/10/2020 às 11:34
-- Versão do servidor: 10.4.14-MariaDB
-- Versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `codigoaberto_novo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `address`
--

CREATE TABLE `address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `address`
--

INSERT INTO `address` (`id`, `user_id`, `zipcode`, `street`, `number`, `complement`, `district`, `city`, `state`, `country`, `created_at`, `updated_at`) VALUES
(2, 7, '15043-310', 'Rua Rachid Abrão Zainum', '3246', 'Fundos', 'Eldorado', 'São José Do Rio Preto', 'SP', 'Brasil', '2020-10-24 20:49:13', '2020-10-24 20:49:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` bigint(20) NOT NULL DEFAULT 1,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` bigint(20) UNSIGNED DEFAULT NULL,
  `category` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 ativo, 2 inativo',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `subtitle` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `views` decimal(10,0) DEFAULT 0,
  `post_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `author`, `category`, `status`, `title`, `uri`, `cover`, `video`, `tag`, `subtitle`, `content`, `views`, `post_at`, `created_at`, `updated_at`) VALUES
(2, 7, NULL, '1', 'Palmeiras aproveita falhas do Atlético-GO e vence no Brasileirão após quatro derrotas seguidas', 'palmeiras-aproveita-falhas-do-atletico-go-e-vence-no-brasileirao-apos-quatro-derrotas-seguidas', 'posts/2020/10/2-palmeiras-aproveita-falhas-do-atletico-go-e-vence-no-brasileirao-apos-quatro-derrotas-seguidas.jpg', '', 'Palmeiras, Verdão', 'Luiz Adriano, duas vezes, e Wesley fazem os gols da vitória alviverde', '<p>A sequência de derrotas do Palmeiras no Brasileirão foi encerrada na tarde deste domingo, no estádio Olímpico, em Goiânia, com vitória de 3 a 0 sobre o Atlético-GO, pela 18ª rodada do campeonato. O time alviverde somava quatro fracassos consecutivos na competição. Luiz Adriano, duas vezes, e Wesley fizeram os gols da partida, marcada por erros grosseiros do Dragão em lances capitais.</p>\n<p>Na tabelaCom a vitória, o Palmeiras assumiu a sétima colocação, com 25 pontos, à beira da zona de classificação para as etapas prévias da Libertadores. O Atlético-GO, com 22, caiu para décimo. Clique aqui e veja a tabela do Brasileirão.<br />Próximos jogosAs duas equipes agora se desligam do Campeonato Brasileiro e focam na Copa do Brasil. Na quarta-feira, o Atlético-GO recebe o Inter às 19h. No dia seguinte, o Palmeiras visita o Bragantino às 19h. O Dragão volta ao Brasileirão no sábado, às 19h, fora de casa, contra o Coritiba. O Verdão joga só na segunda-feira, feriado de 2 de novembro. Recebe o Atlético-MG às 17h.<br /> </p>', '9', '2020-10-25', '2020-10-25 22:21:31', '2020-10-25 23:30:06'),
(3, 7, NULL, '1', 'Claudia Raia relembra casamento com Alexandre Frota: “Era um mulherengo compulsivo”', 'claudia-raia-relembra-casamento-com-alexandre-frota-era-um-mulherengo-compulsivo', 'posts/2020/10/3-claudia-raia-relembra-casamento-com-alexandre-frota-era-um-mulherengo-compulsivo.jpg', '', 'Claudia Raia, Alexandre Frota', 'Claudia Raia irá lançar no próximo mês o seu livro de memória', '<p>Claudia Raia irá lançar no próximo mês o seu livro de memória ‘Sempre Raia Um Novo Dia’, em colaboração com a jornalista Rosana Hermann. Entre vários assuntos, a atriz fala sobre o seu relacionamento com o atual deputado Alexandre Frota, com quem foi casada por três anos.</p>\n<p>“Nunca traí Alexandre, nunca fiz nada para destruir meu casamento. Ao contrário, sempre acreditei na nossa união e sonhava em reproduzir o modelo dos meus pais, tanto que fiz questão de um véu gigante e uma festa pomposa, exatamente para imitar o casamento de minha mãe, que tinha parado a cidade de Campinas. Eu queria um casamento feliz, amoroso, com filhos, do tipo ‘até que a morte os separe’. Mas Alexandre era um mulherengo compulsivo, e eu estava cansada de ouvir alertas de amigos e amigas sobre suas traições”, escreveu Claudia no livro, ao qual a Glamour teve acesso.</p>\n<p>“Quando minha mãe me parou, na porta de entrada da igreja da Candelária, no dia do meu casamento com ele, e disse ‘não case com esse homem’, ela já devia ter conhecimento disso, pois, como descobri anos mais tarde, ela havia contratado um detetive para saber da vida de Alexandre. Apesar de tudo isso, foi ele quem pediu a separação, o que deu um nó na minha cabeça”, relembrou.</p>\n<p> <br />Claudia ainda falou que, apesar de ter pedido a separação, Alexandre não saiu do apartamento da atriz. “Aquilo me deixava totalmente transtornada. Peguei todas as roupas dele, desci e joguei tudo na lagoa. Não na rua, não no lixo. Joguei na Lagoa Rodrigo de Freitas, mesmo. Na água.”</p>\n<p> <br />+ Mulher é empurrada para fora de ônibus após cuspir em homem<br />+ Menino é espancado pelos pais após manter relações sexuais com crianças da família</p>\n<p>“Quando ele voltou, não encontrou mais nada. Em seguida, troquei a fechadura da porta. Ele não pôde mais entrar, mas o porteiro não tinha sido avisado e deixou que ele subisse. Ele ficou chorando do lado de fora da porta, e eu chorando do lado de dentro. Foi complicado, eu ainda gostava dele, mas não abri.”</p>', '7', '2020-10-25', '2020-10-25 23:05:36', '2020-10-25 23:29:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 ativo, 2 inativo',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `testimony`
--

CREATE TABLE `testimony` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` bigint(22) UNSIGNED DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '1 ativo, 2 inativo',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `testimony`
--

INSERT INTO `testimony` (`id`, `author`, `status`, `name`, `cover`, `content`, `created_at`, `updated_at`) VALUES
(8, 7, '1', 'Reinaldo', NULL, 'teeffadsfasasasfsdfd', NULL, NULL),
(9, 7, '1', 'Renan', NULL, '<p>fsdjfakfdasfjsadjfsafsdfsffdsfds</p>', NULL, '2020-10-26 14:33:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logged` bigint(20) DEFAULT NULL,
  `level` bigint(20) NOT NULL DEFAULT 1,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '1 ativo 2 inativo',
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forget` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genre` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '1 male, 2 female',
  `document` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_cookie` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastaccess` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `logged`, `level`, `status`, `first_name`, `last_name`, `email`, `password`, `telephone`, `forget`, `token`, `genre`, `document`, `photo`, `facebook_id`, `google_id`, `user_login`, `user_cookie`, `ip`, `lastaccess`, `datebirth`, `created_at`, `updated_at`) VALUES
(7, NULL, 10, '1', 'Reinaldo', 'Dorti', 'reinaldorti@gmail.com', '$2y$08$2xJmM4.NXtn811qV0nild.5yQPgZY1XG/SKYtnVRa5FOu4trL3OM.', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1603722833', '6dcd317d03b86059d43683d61a0c28d0fc93a26fb1d45b6e2eadd72921eabad17cd33a9790b1400284ae35894b254047f91a3f2b3afbb89d857d31e576994730', '::1', '2020-10-26 11:33:53', NULL, '2020-10-24 20:48:34', '2020-10-26 14:33:53');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_user_id_foreign` (`user_id`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_category_foreign` (`category`),
  ADD KEY `posts_author_foreign` (`author`);
ALTER TABLE `posts` ADD FULLTEXT KEY `title` (`title`);

--
-- Índices de tabela `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `slides` ADD FULLTEXT KEY `title` (`title`);

--
-- Índices de tabela `testimony`
--
ALTER TABLE `testimony`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);
ALTER TABLE `testimony` ADD FULLTEXT KEY `title` (`name`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);
ALTER TABLE `users` ADD FULLTEXT KEY `first_name` (`first_name`,`last_name`,`email`);
ALTER TABLE `users` ADD FULLTEXT KEY `first_name_2` (`first_name`,`last_name`,`email`);
ALTER TABLE `users` ADD FULLTEXT KEY `first_name_3` (`first_name`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `testimony`
--
ALTER TABLE `testimony`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_foreign` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `testimony`
--
ALTER TABLE `testimony`
  ADD CONSTRAINT `testimony_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
