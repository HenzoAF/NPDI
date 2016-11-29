CREATE TABLE administradores (	id INT NOT NULL AUTO_INCREMENT,
																login VARCHAR(50) NOT NULL,
																senha VARCHAR(50) NOT NULL,
                                primeiro_nome VARCHAR(50) NOT NULL,
                                sobre_nome VARCHAR(50),
                                email VARCHAR(100) NOT NULL,
                                PRIMARY KEY(id));

CREATE TABLE posts (id INT NOT NULL AUTO_INCREMENT,
										administradores_id INT NOT NULL,
                    data_criacao DATE NOT NULL,
                    titulo VARCHAR(255) NOT NULL,
                    texto LONGTEXT NOT NULL,
                    PRIMARY KEY(id),
                    CONSTRAINT fk_post_administrador FOREIGN KEY(administradores_id)
                    REFERENCES administradores(id));

CREATE TABLE categorias (	id INT NOT NULL AUTO_INCREMENT,
													administradores_id INT NOT NULL,
													privacidade INT DEFAULT 3,
													titulo VARCHAR(255) NOT NULL,
													descricao VARCHAR(5000),
													PRIMARY KEY(id),
													CONSTRAINT fk_categoria_administrador FOREIGN KEY(administradores_id)
													REFERENCES administradores(id));

CREATE TABLE imagens (id INT NOT NULL AUTO_INCREMENT,
											categorias_id INT NOT NULL,
											administradores_id INT NOT NULL,
											titulo VARCHAR(255) NOT NULL,
											imagem LONGBLOB NOT NULL,
											extensao VARCHAR(50) NOT NULL,
											PRIMARY KEY(id),
											CONSTRAINT fk_imagem_administrador FOREIGN KEY(administradores_id)
											REFERENCES administradores(id),
											CONSTRAINT fk_imagem_categoria FOREIGN KEY (categorias_id)
											REFERENCES categorias(id));
