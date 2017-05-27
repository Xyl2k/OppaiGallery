-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2017 at 00:35 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OppaiGallery`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `latest_medias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `latest_medias` (IN `_count` INT)  SELECT * FROM `medias` M INNER JOIN `users` U ON M.user_id = U.user_id INNER JOIN `media_types` MT ON M.media_type_short_name = MT.media_type_short_name ORDER BY M.media_id DESC LIMIT _count$$

DROP PROCEDURE IF EXISTS `medias_by_tag`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `medias_by_tag` (IN `tag` VARCHAR(16) CHARSET utf8)  SELECT *
	FROM `medias_tags` ST
		INNER JOIN `medias` S ON ST.media_id = S.media_id
		INNER JOIN `users` U ON S.user_id = U.user_id
		INNER JOIN `media_types` M ON S.media_type_short_name = M.media_type_short_name
	WHERE ST.tag_name = tag$$

DROP PROCEDURE IF EXISTS `random_medias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `random_medias` (IN `_count` INT)  SELECT * FROM medias M INNER JOIN users U ON M.user_id = U.user_id INNER JOIN media_types MT ON M.media_type_short_name = MT.media_type_short_name ORDER BY RAND() LIMIT _count$$

DROP PROCEDURE IF EXISTS `tags_count`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `tags_count` ()  SELECT * FROM (
    SELECT *, (
        SELECT COUNT(*)
        FROM medias_tags
        WHERE tag_name = T.tag_name
    ) AS tag_count
    FROM `tags` T
    ORDER BY tag_count DESC
) AS T
WHERE T.tag_count > 0$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `media_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `media_title` varchar(64) NOT NULL,
  `media_comment` varchar(128) NOT NULL,
  `media_url` varchar(2048) NOT NULL,
  `media_type_short_name` varchar(2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `insane` int(1) NOT NULL,
  PRIMARY KEY (`media_id`,`user_id`,`media_type_short_name`),
  KEY `fk_media_type` (`media_type_short_name`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Triggers `medias`
--
DROP TRIGGER IF EXISTS `delete_media`;
DELIMITER $$
CREATE TRIGGER `delete_media` BEFORE DELETE ON `medias` FOR EACH ROW DELETE FROM medias_tags WHERE media_id = OLD.media_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medias_tags`
--

DROP TABLE IF EXISTS `medias_tags`;
CREATE TABLE IF NOT EXISTS `medias_tags` (
  `media_id` bigint(20) NOT NULL,
  `tag_name` varchar(16) NOT NULL,
  UNIQUE KEY `media_id` (`media_id`,`tag_name`),
  KEY `fk_tag` (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
CREATE TABLE IF NOT EXISTS `media_types` (
  `media_type_short_name` varchar(2) NOT NULL,
  `media_type_name` varchar(16) NOT NULL,
  PRIMARY KEY (`media_type_short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `media_types`
--
DROP TRIGGER IF EXISTS `delete_media_type`;
DELIMITER $$
CREATE TRIGGER `delete_media_type` BEFORE DELETE ON `media_types` FOR EACH ROW DELETE FROM medias WHERE media_type_short_name = OLD.media_type_short_name
$$
DELIMITER ;

--
-- Dumping data for table `media_types`
--

INSERT INTO `media_types` (`media_type_short_name`, `media_type_name`) VALUES
('am', 'Anime'),
('dj', 'Doujinshi'),
('gm', 'Games'),
('im', 'Image'),
('mg', 'Manga'),
('rl', 'Real Life'),
('rp', 'Real Life Photo');

-- --------------------------------------------------------


--
-- Table structure for table `tags`
--
DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_name` varchar(16) NOT NULL,
  PRIMARY KEY (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Triggers `tags`
--
DROP TRIGGER IF EXISTS `delete_tag`;
DELIMITER $$
CREATE TRIGGER `delete_tag` BEFORE DELETE ON `tags` FOR EACH ROW DELETE FROM medias_tags WHERE tag_name = OLD.tag_name
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_tag`;
DELIMITER $$
CREATE TRIGGER `update_tag` BEFORE UPDATE ON `tags` FOR EACH ROW INSERT INTO tags (tag_name) VALUES (NEW.tag_name)
$$
DELIMITER ;


--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_name`) VALUES
('3d'),
('abortion'),
('absorption'),
('age.progression'),
('age.regression'),
('ageplay'),
('ahegao'),
('albino'),
('alien'),
('alien.girl'),
('amputee'),
('anaglyph'),
('anal'),
('anal.birth'),
('angel'),
('animal.on.animal'),
('animal.on.furry'),
('animated'),
('anorexic'),
('anthology'),
('apron'),
('armpit.licking'),
('armpit.sex'),
('armpits'),
('artbook'),
('asmr'),
('asphyxiation'),
('ass.expansion'),
('assjob'),
('audio'),
('aunt'),
('autopaizuri'),
('ball.sucking'),
('balljob'),
('balls.expansion'),
('bandages'),
('bandaid'),
('bbm'),
('bbw'),
('bdsm'),
('bear'),
('bee.girl'),
('bestiality'),
('big.areolae'),
('big.ass'),
('big.balls'),
('big.breasts'),
('big.clit'),
('big.lips'),
('big.nipples'),
('big.penis'),
('big.vagina'),
('bike.shorts'),
('bikini'),
('birth'),
('blackmail'),
('blind'),
('blindfold'),
('blood'),
('bloomers'),
('blowjob'),
('blowjob.face'),
('body.painting'),
('body.swap'),
('body.writing'),
('bodystocking'),
('bodysuit'),
('bondage'),
('braces'),
('brain.fuck'),
('breast.expansion'),
('breast.feeding'),
('breast.reduction'),
('bride'),
('brother'),
('bukkake'),
('bull'),
('bunny.boy'),
('bunny.girl'),
('burping'),
('business.suit'),
('butler'),
('camel'),
('cameltoe'),
('camshow'),
('cannibalism'),
('caption'),
('cashier'),
('cat'),
('catboy'),
('catfight'),
('catgirl'),
('cbt'),
('centaur'),
('chastity.belt'),
('cheating'),
('cheerleader'),
('chikan'),
('chinese.dress'),
('chloroform'),
('christmas'),
('chubby'),
('clit.growth'),
('coach'),
('cockslapping'),
('collar'),
('compilation'),
('condom'),
('conjoined'),
('coprophagia'),
('corruption'),
('corset'),
('cosplay'),
('cosplaying'),
('cousin'),
('cow.girl'),
('cowgirl'),
('cowman'),
('crab'),
('creampie'),
('crossdressing'),
('cum.in.eye'),
('cum.play'),
('cum.swap'),
('cunnilingus'),
('cuntboy'),
('dakimakura'),
('dark.nipples'),
('dark.skin'),
('daughter'),
('deepthroat'),
('defloration'),
('demon'),
('demon.girl'),
('diaper'),
('dick.growth'),
('dicknipples'),
('dilf'),
('dinosaur'),
('dog'),
('dog.boy'),
('dog.girl'),
('doll.joints'),
('dolphin'),
('donkey'),
('double.anal'),
('double.blowjob'),
('double.vaginal'),
('dougi'),
('draenei'),
('dragon'),
('drugs'),
('drunk'),
('ear.fuck'),
('eel'),
('eggs'),
('electric.shocks'),
('elephant'),
('elf'),
('elve'),
('emotionless.sex'),
('enema'),
('exhibitionism'),
('eye.penetration'),
('eyemask'),
('eyepatch'),
('facesitting'),
('facial'),
('fairy'),
('farting'),
('father'),
('femdom'),
('feminization'),
('ffm.threesome'),
('fft.threesome'),
('figure'),
('filming'),
('fingering'),
('fish'),
('fisting'),
('foot.insertion'),
('foot.licking'),
('footjob'),
('forniphilia'),
('fox'),
('fox.boy'),
('fox.girl'),
('freckles'),
('frog'),
('frottage'),
('full.body.tattoo'),
('full.censorship'),
('full.color'),
('fundoshi'),
('funny'),
('furry'),
('futanari'),
('futanari.on.futa'),
('futanari.on.male'),
('gag'),
('game'),
('game.sprite'),
('gaping'),
('garter.belt'),
('gasmask'),
('gender.bender'),
('ghost'),
('giant'),
('giantess'),
('girls.only'),
('glasses'),
('glory.hole'),
('goat'),
('goblin'),
('gokkun'),
('gorilla'),
('gothic.lolita'),
('granddaughter'),
('grandfather'),
('grandmother'),
('gravure'),
('group'),
('growth'),
('guro'),
('guys.only'),
('gyaru'),
('gyaruoh'),
('gymshorts'),
('haigure'),
('hairjob'),
('hairy'),
('hairy.armpits'),
('handicapped'),
('handjob'),
('hardcore'),
('harem'),
('harpy'),
('hijab'),
('horse'),
('horse.boy'),
('horse.cock'),
('horse.girl'),
('hotpants'),
('how.to'),
('huge.breasts'),
('huge.penis'),
('human.cattle'),
('human.pet'),
('humiliation'),
('images'),
('impregnation'),
('incest'),
('incubus'),
('infantilism'),
('inflation'),
('insect'),
('insect.boy'),
('insect.girl'),
('inseki'),
('inverted.nipples'),
('invisible'),
('japanese'),
('JAV'),
('junior.idol'),
('kappa'),
('kigurumi'),
('kimono'),
('kissing'),
('kneepit.sex'),
('kunoichi'),
('lab.coat'),
('lactation'),
('large.insertions'),
('latex'),
('layer.cake'),
('leg.lock'),
('legjob'),
('leotard'),
('lingerie'),
('lion'),
('lioness'),
('living.clothes'),
('lizard.girl'),
('lizard.guy'),
('lolicatgirls'),
('lolicon'),
('long.tongue'),
('low.bestiality'),
('low.lolicon'),
('low.shotacon'),
('low.toddlercon'),
('machine'),
('maggot'),
('magical.girl'),
('maid'),
('male.on.futanari'),
('masked.face'),
('massage'),
('masturbation'),
('mecha.boy'),
('mecha.girl'),
('menstruation'),
('mermaid'),
('merman'),
('metal.armor'),
('midget'),
('miko'),
('milf'),
('military'),
('milking'),
('mind.break'),
('mind.control'),
('minigirl'),
('miniguy'),
('minotaur'),
('missing.cover'),
('mmf.threesome'),
('mmt.threesome'),
('monkey'),
('monster'),
('monster.girl'),
('mother'),
('motorboating'),
('mouse'),
('mouse.boy'),
('mouse.girl'),
('mtf.threesome'),
('multiple.arms'),
('multiple.breasts'),
('multiple.paizuri'),
('multiple.penises'),
('muscle'),
('muscle.growth'),
('mute'),
('nakadashi'),
('navel.fuck'),
('nazi'),
('necrophilia'),
('netorare'),
('niece'),
('ninja'),
('nipple.birth'),
('nipple.expansion'),
('nipple.fuck'),
('no.sex'),
('non-nude'),
('nonnude'),
('nose.fuck'),
('nose.hook'),
('novel'),
('nude'),
('nukige'),
('nun'),
('nurse'),
('octopus'),
('office.lady'),
('oil'),
('old.lady'),
('old.man'),
('onahole'),
('oni'),
('orc'),
('orgasm.denial'),
('ostrich'),
('out.of.order'),
('paizuri'),
('panther'),
('pantyhose'),
('pantyjob'),
('paperchild'),
('parasite'),
('pasties'),
('pegging'),
('penis.birth'),
('petrification'),
('phimosis'),
('phone.sex'),
('piercing'),
('pig'),
('pig.girl'),
('pig.man'),
('pillory'),
('piss.drinking'),
('plant.girl'),
('plant.guy'),
('pole.dancing'),
('policeman'),
('policewoman'),
('ponygirl'),
('poor.grammar'),
('possession'),
('pov'),
('pregnant'),
('prehensile.hair'),
('prolapse'),
('prostate.massage'),
('prostitution'),
('pubic.stubble'),
('public.use'),
('puni'),
('rabbit'),
('raccoon.boy'),
('raccoon.girl'),
('race.queen'),
('randoseru'),
('rape'),
('realporn'),
('redraw'),
('replaced'),
('reptile'),
('rewrite'),
('rhinoceros'),
('rimjob'),
('robot'),
('robot.girl'),
('ryona'),
('saliva'),
('sample'),
('scanmark'),
('scar'),
('scat'),
('school.swimsuit'),
('schoolboy'),
('schoolgirl'),
('scrotal.lingerie'),
('selfcest'),
('sex.toys'),
('shared.senses'),
('shark'),
('shaved'),
('sheep'),
('sheep.boy'),
('sheep.girl'),
('shemale'),
('shibari'),
('shimapan'),
('shindol'),
('shotacon'),
('shrinking'),
('sign'),
('sister'),
('skinsuit'),
('slave'),
('sleeping'),
('slime'),
('slime.boy'),
('slime.girl'),
('slug'),
('small breasts'),
('small.breasts'),
('smegma'),
('smell'),
('smoking'),
('snake'),
('snake.girl'),
('snake.guy'),
('snuff'),
('solo.action'),
('spanking'),
('speculum'),
('speechless'),
('spider'),
('spider.girl'),
('squid.girl'),
('squirting'),
('stereoscopic'),
('stewardess'),
('stockings'),
('story.arc'),
('strapon'),
('stretching'),
('striptease'),
('stuck.in.wall'),
('succubus'),
('sumata'),
('sundress'),
('sunglasses'),
('sweating'),
('swimsuit'),
('swinging'),
('syringe'),
('tailjob'),
('tall.girl'),
('tall.man'),
('tankoubon'),
('tanlines'),
('teacher'),
('Tentacles'),
('text.cleaned'),
('thai'),
('themeless'),
('thigh.high.boots'),
('threesome'),
('tiara'),
('tickling'),
('tiger'),
('tights'),
('time.stop'),
('toddlercon'),
('tomboy'),
('tooth.brushing'),
('torture'),
('tracksuit'),
('trampling'),
('transformation'),
('trap'),
('tribadism'),
('triple.anal'),
('triple.penetrati'),
('triple.vaginal'),
('tsundere'),
('ttf.threesome'),
('ttm.threesome'),
('tube'),
('tutor'),
('twins'),
('twintails'),
('unbirth'),
('uncle'),
('underwater'),
('unicorn'),
('unusual.pupils'),
('urination'),
('vacbed'),
('vaginal.sticker'),
('vampire'),
('video'),
('virginity'),
('visual.novel'),
('voice'),
('vomit'),
('vore'),
('voyeurism'),
('waiter'),
('watermarked'),
('weight.gain'),
('whale'),
('whip'),
('widow'),
('widower'),
('wings'),
('witch'),
('wolf'),
('wolf.boy'),
('wolf.girl'),
('wooden.horse'),
('worm'),
('wrestling'),
('xray'),
('yandere'),
('yaoi'),
('yukkuri'),
('yuri'),
('zebra'),
('zombie');

-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
CREATE TABLE IF NOT EXISTS `media_types` (
  `media_type_short_name` varchar(2) NOT NULL,
  `media_type_name` varchar(16) NOT NULL,
  PRIMARY KEY (`media_type_short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `media_types`
--
DROP TRIGGER IF EXISTS `delete_media_type`;
DELIMITER $$
CREATE TRIGGER `delete_media_type` BEFORE DELETE ON `media_types` FOR EACH ROW DELETE FROM medias WHERE media_type_short_name = OLD.media_type_short_name
$$
DELIMITER ;

--
-- Dumping data for table `media_types`
--

INSERT INTO `media_types` (`media_type_short_name`, `media_type_name`) VALUES
('am', 'Anime'),
('dj', 'Doujinshi'),
('gm', 'Games'),
('im', 'Image'),
('mg', 'Manga'),
('rl', 'Real Life'),
('rp', 'Real Life Photo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `delete_user`;
DELIMITER $$
CREATE TRIGGER `delete_user` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM medias WHERE user_id = OLD.user_id
$$
DELIMITER ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`) VALUES
(1, 'root');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `fk_media_type` FOREIGN KEY (`media_type_short_name`) REFERENCES `media_types` (`media_type_short_name`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `medias_tags`
--
ALTER TABLE `medias_tags`
  ADD CONSTRAINT `fk_media` FOREIGN KEY (`media_id`) REFERENCES `medias` (`media_id`),
  ADD CONSTRAINT `fk_tag` FOREIGN KEY (`tag_name`) REFERENCES `tags` (`tag_name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
