CREATE TABLE enum (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, value BIGINT NOT NULL, INDEX value_idx (value), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE friendships (id BIGINT AUTO_INCREMENT, usera_id BIGINT NOT NULL, userb_id BIGINT NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE pending_user (id BIGINT AUTO_INCREMENT, email VARCHAR(255) NOT NULL UNIQUE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE wishlist_item (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, price BIGINT NOT NULL, is_public TINYINT(1) DEFAULT '1' NOT NULL, user_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE wishlist_user (name VARCHAR(255) NOT NULL, gender BIGINT DEFAULT 1, age BIGINT DEFAULT 18 NOT NULL, email VARCHAR(255) NOT NULL, wishlistuser_id BIGINT AUTO_INCREMENT, password VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX gender_idx (gender), PRIMARY KEY(wishlistuser_id)) ENGINE = INNODB;
ALTER TABLE wishlist_item ADD CONSTRAINT wishlist_item_user_id_wishlist_user_wishlistuser_id FOREIGN KEY (user_id) REFERENCES wishlist_user(wishlistuser_id) ON DELETE CASCADE;
ALTER TABLE wishlist_user ADD CONSTRAINT wishlist_user_gender_enum_value FOREIGN KEY (gender) REFERENCES enum(value);
