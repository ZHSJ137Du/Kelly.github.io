CREATE DATABASE education DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE education;

CREATE TABLE `user`(
	`id` int AUTO_INCREMENT PRIMARY KEY,
	`user_name` VARCHAR(20) NOT NULL,
	`user_pwd` VARCHAR(32) NOT NULL,
	`user_icon`	VARCHAR(300),
	`phone`	VARCHAR(13),
	`email` VARCHAR(20),
	`power` int NOT NULL DEFAULT 0
);
/*
	用户表
		ID
		用户名
		用户密码	md5加密
		用户头像地址
		手机号
		邮箱
		权限  0为一般用户，1为管理员

//可能需要补全和修改
*/


CREATE TABLE `course_type`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`type_name` VARCHAR(20) NOT NULL,
	`has_sub` TINYINT NOT NULL DEFAULT 0,
	`father_id` INT NOT NULL DEFAULT 0
);
/*
	课程类别表
		ID
		课程类别名称
		是否有子类别	没有则为0
		父类别的ID	没有父类别则为0
*/


CREATE TABLE `course`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`course_name` VARCHAR(20) NOT NULL,
	`course_info` VARCHAR(500),
	`course_icon` VARCHAR(300),
	`type_id` INT NOT NULL,
	`video_url` varchar(200) DEFAULT NULL,
	`create_user` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`student_num` INT NOT NULL DEFAULT 0,
	`click_num` INT NOT NULL DEFAULT 0,
	`score`	INT ,
	`status` INT NOT NULL DEFAULT 0,
	FOREIGN KEY(`type_id`) REFERENCES `course_type`(`id`),
	FOREIGN KEY(`create_user`) REFERENCES `user`(`id`)
);

/*
	课程由用户创建，不需要通过后台申请，后台可以管理
	课程表
		ID
		课程名
		课程信息
		课程图标地址
		课程类别ID
		创建课程用户ID
		创建时间
		学员数
		点击量
		评分
		课程状态(可以不使用，自定)
*/


CREATE TABLE `course_content`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`course_id` INT NOT NULL,
	`course_no` INT NOT NULL,
	`title` VARCHAR(20) NOT NULL,
	`content_info` VARCHAR(500) NOT NULL,
	`video_url` VARCHAR(300) NOT NULL,
	`create_user` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL,
	`click_num` INT NOT NULL DEFAULT 0,
	`status` INT NOT NULL DEFAULT 0,
	FOREIGN KEY(`course_id`) REFERENCES `course`(`id`),
	FOREIGN KEY(`create_user`) REFERENCES `user`(`id`)
);


/*
	课时表
		ID
		所属课程ID
		所属课程的第course_no课时
		课时标题
		课时简介
		视频地址
		添加用户的ID
		添加时间
		浏览量
		课时状态(可以不使用，自定)
*/



CREATE TABLE `course_chapter`(
	`course_id` INT NOT NULL,
	`chapter_no` INT NOT NULL,
	`start_no`	INt NOT NULL,
	PRIMARY KEY(`course_id`,`chapter_no`),
	FOREIGN KEY(`course_id`) REFERENCES `course`(`id`)
);

/*
	课程章节表
		课程ID
		章节号
		开始课时
*/




CREATE TABLE `user_course`(
	`user_id` INT NOT NULL,
	`course_id` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL,
	`status` INT NOT NULL DEFAULT 0,
	`power` INT NOT NULL DEFAULT 0,
	PRIMARY KEY(`user_id`,`course_id`),
	FOREIGN KEY(`user_id`) REFERENCES `user`(`id`),
	FOREIGN KEY(`course_id`) REFERENCES `course`(`id`)
);

/*
	用户课程表
		用户ID
		课程ID
		加入课程时间
		状态
		该用户在对应课程内权限(有权限添加课时之类，自定)
*/


CREATE TABLE `community_type`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`type_name` VARCHAR(20) NOT NULL
);

/*
	社区类型表
		ID
		社区类型名
*/

CREATE TABLE `community`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`comm_name` VARCHAR(20) NOT NULL,
	`comm_type` INt NOT NULL,
	`comm_icon` VARCHAR(300),
	`comm_info` VARCHAR(500) NOT NULL,
	`create_user` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL,
	`status` INT NOT NULL DEFAULT 0,
	FOREIGN KEY(`create_user`) REFERENCES `user`(`id`),
	FOREIGN KEY(`comm_type`) REFERENCES `community_type`(`id`)
);


/*
	社区由用户创建和修改，不需要申请，后台可以管理

	社区表
		ID
		社区名称
		社区类型ID
		社区图像地址
		社区简介
		创建用户ID
		创建时间
		状态(可以不需要，自定)
*/

CREATE TABLE `user_community`(
	`user_id` INT NOT NULL,
	`commid` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL,
	`status` INT NOT NULL DEFAULT 0,
	`power` INT NOT NULL DEFAULT 0,
	PRIMARY KEY(`user_id`,`commid`),
	FOREIGN KEY(`user_id`) REFERENCES `user`(`id`),
	FOREIGN KEY(`commid`) REFERENCES `community`(`id`)
);

/*
	用户社区表
		用户ID
		社区ID
		加入时间
		状态
		权限(组长之类，详细权限的作用自定)
*/

CREATE TABLE `topic`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`topic_title` VARCHAR(20) NOT NULL,
	`comm_id` INT NOT NULL,
	`article_content` VARCHAR(3000) NOT NULL,
	`click_num` INT NOT NULL DEFAULT 0,
	`create_time` TIMESTAMP NOT NULL,
	FOREIGN KEY(`comm_id`) REFERENCES `community`(`id`)
);

/*
	社区话题(讨论)表
		ID
		话题标题
		社区ID
		话题内容
		点击量
		创建时间
*/



CREATE TABLE `article_type`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`type_name` VARCHAR(20) NOT NULL
);

/*
	文章类别表
		ID
		文章类别
*/

CREATE TABLE `article`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`article_title` VARCHAR(20) NOT NULL,
	`article_content` VARCHAR(3000) NOT NULL,
	`article_type` INT NOT NULL,
	`img`	VARCHAR(300),
	`key_word` VARCHAR(100),
	`click_num` INT NOT NULL DEFAULT 0,
	`hot`	TINYINT ,
	`create_time` TIMESTAMP NOT NULL,
	FOREIGN KEY(`article_type`) REFERENCES `article_type`(`id`)
);


/*
	文章表
		ID
		文章标题
		文章内容
		文章图片
		点击量
		关键字
		热度
		创建时间
*/




CREATE TABLE `comment`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT NOT NULL,
	`comment_content` VARCHAR(300) NOT NULL,
	`comment_type` INT NOT NULL DEFAULT 0,
	`src_id` INT NOT NULL,
	`create_time` TIMESTAMP NOT NULL,
	FOREIGN KEY(`user_id`) REFERENCES `user`(`id`)
);


/*
	评论表
		ID
		评论者
		评论内容
		评论的文章类型(课时、话题、文章)
		对应文章类型的ID
		评论时间
*/



CREATE TABLE `sys`(
	`key`	VARCHAR(20) NOT NULL,
	`value`	VARCHAR(300) NOT NULL
);

/*
	系统设置
*/

CREATE TABLE `index_banner` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`img_url` varchar(200) NOT NULL,
	`link` varchar(200) DEFAULT NULL,
	PRIMARY KEY (`key`)
);
/* 
	主页banner设置
*/
