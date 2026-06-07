-- =====================================================
--  LOJA MULTI-TENANCY — Dump MySQL
--  Duas empresas, mesmo banco, mesmo código
--  Importe em: phpMyAdmin > loja_multitenant > Importar
-- =====================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Tabela: empresas (os TENANTS)
-- ----------------------------
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `dominio` varchar(255) DEFAULT NULL COMMENT 'Domínio de produção, ex: minha-loja.com',
  `cor_primaria` varchar(255) NOT NULL DEFAULT '#0d6efd' COMMENT 'Cor primária da loja em hex',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresas_usuario_unique` (`usuario`),
  UNIQUE KEY `empresas_email_unique` (`email`),
  UNIQUE KEY `empresas_slug_unique` (`slug`),
  UNIQUE KEY `empresas_dominio_unique` (`dominio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `empresas` (`id`,`nome`,`usuario`,`email`,`password`,`slug`,`dominio`,`cor_primaria`,`ativo`,`created_at`,`updated_at`) VALUES
(1,'Tech Solutions Ltda','empresa_a','contato@techsolutions.com','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','tech','loja-a.com','#1d4ed8',1,NOW(),NOW()),
(2,'Café Gourmet ME','empresa_b','contato@cafegourmet.com','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','cafe','loja-b.com','#92400e',1,NOW(),NOW());
-- SENHA DE AMBAS: 123456

-- ----------------------------
-- Tabela: produtos
-- ----------------------------
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint UNSIGNED NOT NULL COMMENT 'FK do tenant dono deste produto',
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produtos_empresa_id_foreign` (`empresa_id`),
  CONSTRAINT `produtos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `produtos` (`empresa_id`,`nome`,`descricao`,`preco`,`estoque`,`ativo`,`created_at`,`updated_at`) VALUES
-- ← empresa_id=1 → só aparece em localhost:8000 (Tech Solutions)
(1,'Notebook Pro 15','Notebook para desenvolvedores',4999.90,15,1,NOW(),NOW()),
(1,'Mouse Ergonômico','Mouse vertical sem fio',189.90,50,1,NOW(),NOW()),
(1,'Teclado Mecânico','Switch Blue, ABNT2',349.90,30,1,NOW(),NOW()),
(1,'Monitor 27" 4K','IPS, 144Hz, HDR',2199.00,8,1,NOW(),NOW()),
-- ← empresa_id=2 → só aparece em localhost:8001 (Café Gourmet)
(2,'Café Especial 250g','Origem única, torra média',38.90,200,1,NOW(),NOW()),
(2,'Chemex 6 xícaras','Coador de vidro borossilicato',219.00,20,1,NOW(),NOW()),
(2,'Moedor Manual','Cerâmica ajustável',149.00,35,1,NOW(),NOW());

-- ----------------------------
-- Tabela: banners
-- ----------------------------
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint UNSIGNED NOT NULL COMMENT 'FK do tenant dono deste banner',
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `url_link` varchar(255) DEFAULT NULL,
  `cor_fundo` varchar(255) NOT NULL DEFAULT '#000000',
  `ordem` int NOT NULL DEFAULT 1,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banners_empresa_id_foreign` (`empresa_id`),
  CONSTRAINT `banners_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `banners` (`empresa_id`,`titulo`,`subtitulo`,`cor_fundo`,`ordem`,`ativo`,`created_at`,`updated_at`) VALUES
(1,'Bem-vindo à Tech Solutions','Tecnologia de ponta para o seu negócio','#1d4ed8',1,1,NOW(),NOW()),
(1,'Novos produtos chegaram!','Confira as novidades','#7c3aed',2,1,NOW(),NOW()),
(2,'Café Especial Direto ao Paladar','Origem única, torra artesanal','#92400e',1,1,NOW(),NOW()),
(2,'Novidade: Chemex chegou!','O método perfeito para o seu café','#78350f',2,1,NOW(),NOW());

-- ----------------------------
-- Tabelas auxiliares do Laravel
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2024_01_01_000001_create_empresas_table', 1),
('2024_01_01_000002_create_produtos_table', 1),
('2024_01_01_000003_create_banners_table', 1),
('2024_01_02_000000_add_tenant_fields_to_empresas_table', 1);

SET FOREIGN_KEY_CHECKS = 1;
