-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 05:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moevoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(5) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `email`, `name`, `password`, `role`) VALUES
(1, 'bambang@gmail.com', 'Bambang Suryapantoro', '$2y$10$9..V0UtMVKyUS0/7MxvZseSLlm3kkf0LWIBNU.Yr2Tdd3ztltwg4i', 'admin'),
(2, 'supri@gmail.com', 'Supri Amar Zulkifli', '$2y$10$DKQwDndU9Y43pt4YHBBane97TwMoYvS4.IgTN55X8VvTj1O0y42.K', 'user'),
(4, 'alex1@gmail.com', 'Wih ada Mas Alex cuk', '$2y$10$AMvwR6mBxuWcvT/x3TdIL.c1UIdExFRC95PlAdHtmq45HwdNDTSQ6', 'user'),
(5, 'jackpot@gmail.com', 'Jackpot Jackpot OH YEAH OH YEA', '$2y$10$fwVv5zmnV4gATD3vZ5OtQ.cz9iKL8MWh1OOL2Fv9NXL5hj9HWtwfu', 'user'),
(6, 'novrindawg@gmail.com', 'Novrindo Chairilbaldi', '$2y$10$Z7asnrJD1YVSaKvibZSUL.u.wk9YlDZL/ROWHQ8lyydgGlNWES3ZS', 'user'),
(7, 'hidayat@gmail.com', 'gus dayat', '$2y$10$XrzeHxAZn66/rzhOZfu87e3kgxyxvQuSeuySflC9zz1wZbDSZvF12', 'user'),
(8, 'khalidmlbb@email.com', 'Bapak Hj. Khaleed', '$2y$10$auT7wLApkVfyaFeEaqnB.Ol/QZyO.bQuwuZGdqlWa519K/0P8byyG', 'user'),
(9, 'kingkifa@gmail.com', 'Khalid Ibnu Faisal Aziz', '$2y$10$cJPOQiUj1yxrElAguOO1pOGNjUNmhUdfe1c.6xjlgn0tKtSJZJEfu', 'user'),
(10, 'theadmin@email.com', 'Super Admin', '$2y$10$.IxpQoU/sfXcMDpW6KUDeuRIr5tAzoxiSnTjd5ZV4EcBF9pk9L/qy', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image`, `created_at`, `author_id`) VALUES
(1, 'The Bad Guys 2 the mid sequel', 'Usually, it takes three or four films for a franchise to end up in outer space. Even the “Fast and Furious” series waited until “F9: The Fast Saga” to send Tyrese Gibson and Ludacris to the stars in a Pontiac Fiero. “The Bad Guys 2” goes there in just the first sequel. That’s how quickly it seems the filmmakers have run out of ideas. \r\n\r\nThe follow-up to the 2022 DreamWorks Animation hit “The Bad Guys,” about a crew of fun-loving criminals who also happen to be animals, maintains the pizazz of its sleekly angular visual style. And the game voice cast returns, led by a reliably roguish Sam Rockwell. But increasingly, the antics feel strained, and the action grows needlessly complicated. The reason everyone winds up in space is especially convoluted and, ironically, not all that transporting. \r\n\r\nThere’s promise off the top, though, with a flashback to a heist from five years earlier in Cairo. Ringleader Mr. Wolf (Rockwell), safecracker Mr. Snake (Marc Maron), master of disguise Mr. Shark (Craig Robinson), and jack-of-all-trades Mr. Pirahna (Anthony Ramos) are stealing a flashy muscle car from a billionaire’s penthouse with the help of their newest team member, the hacker Ms. Tarantula (Awkwafina). The banter is snappy, the chase is zippy, and the escape is full of thrills–and then it’s pretty much all downhill from there. \r\n\r\nAn efficient “previously on” explainer from the smooth Wolf catches us up: He and his team have been trying to go straight since the events of the first film, hoping to become better known as The Good Guys. A bland job interview montage indicates how well this new strategy is going. They commiserate in their industrial-chic loft, hidden within the Los Angeles River storm drain system. Director Pierre Perifel and his vast team of animators once again capture the eclectic cool of this multi-cultural city, which is most vibrantly on display during a colorful, high-energy set piece at a Lucha Libre event. \r\n\r\nBut just when they thought they were out, they get pulled back in when they’re framed for a series of high-profile thefts. (The name of the metal inside all these valuable objects provides the one big laugh-out-loud line in the script from writers Yoni Brenner and Etan Cohen, adapting Aaron Blabey’s book series.)  \r\n\r\nWolf & Co. Get dragged into the tried-and-true one last heist, reluctantly working alongside the fearsome female team of Kitty Kat (Danielle Brooks), Doom (Natasha Lyonne in wry “Poker Face” mode), and Pigtail (Maria Bakalova). At the same time, they’re trying to protect the secret identity of Gov. Diane Foxington (Zazie Beetz), with whom Wolf’s been enjoying an ill-advised flirtation. And of course, the diminutive and diabolical guinea pig Professor Marmalade (Richard Ayoade) returns to serve as a chaos agent. \r\n\r\n\r\nEventually, though, the whole effort feels chaotic, crammed as it is with uninspired pop culture references and way, way too many fart jokes, even for a movie aimed at kids. Pirahna’s flatulence is basically the fuel of the zany, outer-space conclusion–that’s how prominent it is. At one point during this sequence, I wrote in my notes, “What are the stakes?” because the new bad guys (or gals) are simply greedy, nothing more. Even the obvious Elon Musk figure, voiced by Colin Jost, isn’t truly villainous. \r\n\r\nThankfully, the film’s look is always wondrous, from the haunting, spare lighting of a phone booth in the desert at night to the lustrous lowriders bopping up and down outside a stadium. When there’s a “Bad Guys 3”–and the ending very much suggests there will be a “Bad Guys 3”–at least it will be pretty, if not necessarily good.', 'img/articles/1761550502_angrybird.jpg', '2025-10-27 13:22:11', 1),
(2, 'Weapons Critic Review', 'It\'s an intriguing place to start a horror film, made all the more unusual by \"Weapons\" writer-director Zach Cregger\'s decision to have a local girl describe the film\'s seemingly supernatural premise. How much of the shocking and shockingly bloody events that follow could he have been aware of? It doesn\'t matter. As the unnamed young narrator says of her companions\' disappearance, \"The police and the higher-ups in this town... couldn\'t solve it,\" a statement that sets us up for a mystery that will remain unexplained, one that has recently become a successful horror subgenre, with films like \"Hereditary\" and \"Longlegs\" leaning toward ambiguity.\r\n\r\nFor three-quarters of the film, this approach lets our imagination run wild. Only when the answer emerges does \"Weapons\" begin to lose its appeal. Regardless of how you feel about the ending (and many will enjoy the film\'s darkly comic finale), Cregger has achieved something remarkable, creating a cruel and twisted bedtime story, in the style of the Brothers Grimm—not the children\'s Disney version, mind you, but the kind where characters kill at will and the audience struggles to sleep afterward.\r\n\r\nSignificantly expanding the scope and potency of his sinister powers of suggestion, Cregger arrives at this final nightmare of 2022\'s brilliantly disturbing \"Barbarian,\" in which a hellish vacation rental was merely a facade beneath which all manner of evil had been allowed to fester. He possesses a mind exceptionally adept at revealing the threats lurking behind seemingly harmless settings—in this case, a Pennsylvania town called Maybrook, where a mass disappearance turns placid parents into an angry mob.\r\n\r\n\r\n\r\nThe relatable setting and imperfect collection of characters (made up of people whose flaws make them even more relatable) suggest the best Stephen King film that Stephen King never wrote. As long as the children remain missing, our minds are free to make any associations that arise. Some might gravitate toward QAnon-style conspiracies, where shadowy child predators prey on the nation\'s youth (tonally, the film resembles Denis Villeneuve\'s dark \"Prisoners\"). For me, the community\'s reaction reminded me of the painful aftermath of a school shooting, as parents search for answers, comfort, and blame, roughly in that order.\r\n\r\nJosh Brolin, playing the irascible guy who likely bullied his classmates at school, plays a father named Archer Graff, whose son Matt has disappeared. He shows up at a school assembly and implicates Justine (Julia Garner), demanding to know what the teacher did to her children. This accusation hits especially hard in such politicized times, as real-life parents unite to confront school staff and policies they fear may be brainwashing their children.\r\n\r\n\r\n\r\nRather than choosing a single character to follow throughout the film, Cregger divides the mystery among six people, separated into distinct chapters, beginning with Justine. Only one (the last) has all the answers, while the others provide fresh perspectives on the overall situation, as the story rewinds with each new section, allowing us to relive key scenes from someone else\'s perspective: there\'s the teacher (Garner), the father (Brolin), the police officer (Alden Ehrenreich), the school administrator (Benedict Wong), and two others whose identities are best kept secret.\r\n\r\nThe pieces fit together like an expertly crafted puzzle, inducing a sense of satisfaction as certain details fall into place, from the identity of the person who scrawled \"WITCH\" on Justine\'s car to why the scruffy drug addict (Austin Abrams), assaulted by the police, risks approaching the station. Throughout the proceedings, Cregger glimpses a face with smudged, clown-like makeup. \r\n\r\nFor over an hour, the film adopts a somber, serious tone, reinforced by Larkin Seiple\'s steady camerawork and a bone-rattling score. But once Gladys appears, \"Weapons\" takes an unexpectedly over-the-top turn. By then, Cregger has upped the ante, presenting an adult turned homicidal by the same suggestive force that drove the children to run away from home. But as we begin to understand why all this is happening, the runaway ideas Cregger\'s concept unleashed in our minds narrow down to a single, inevitably limiting explanation.\r\n\r\nAs in \"Barbarian,\" the violence escalates in the final stretch, as the title becomes clearer and we realize that the community is made up of two kinds of people: targets and weapons, and virtually anything, from an impressionable child to a vegetable peeler, can become dangerous in the wrong hands.', 'img/articles/iotLayer.jpg', '2025-10-27 14:12:14', 1),
(3, 'Absolute Cinema', 'The Wild Robot isn’t your traditional Fantastic Fest film. It’s a little sci-fi, sure, but on the surface, it just seems like another children’s animated film. Truthfully, though, The Wild Robot is a thoughtful narrative that uses its genre to propel its theme in a moving way.\r\n\r\nAfter a shipwreck, an intelligent robot named Roz is stranded on an uninhabited island and must learn to adapt to the harsh environment, gradually bonding with the island’s animals and becoming the adoptive parent of an orphaned gosling whom she names Brightbill. Feed him, teach him to swim, and make sure he flies before winter. That’s her task. But those three simple things propel her into motherhood and a life she didn’t know was possible.\r\n\r\nWhen I first walked into The Wild Robot, I didn’t expect it to land completely for me. The score is beautiful. The animation is breathtaking, but motherhood? I mean, how many films about motherhood and connection have we seen in recent years, especially in animation of all ages? That said, The Wild Robot takes those expectations and blows them out of the water. As much as the film is about being a mother and not understanding what that entirely means, it’s also about being a kid.\r\n\r\nWithout hesitation, The Wild Robot makes jokes about motherhood that continuously allude to the fact that sometimes you just have to figure it out. It’s rough and thankless, but it’s also terrifying. How do you fulfill your task of keeping this fragile life alive when everything is rigged against it?\r\n\r\nAt the same time, however, Brightbill also learns how to be a child. It’s a weird situation and way of looking at coming of age as something that doesn’t necessarily happen when you transition stages in your life cycle. Still, instead, at the relationship you have with your parent. The film is comedic and warm. It’s fit for parents and children, and when you let it wash over you, the theme becomes engrossing. But it’s not something realized at the moment.\r\n\r\nThe Wild Robot Review\r\n\r\nAt the middle point of the film, I just started crying. We all know that Roz is not Brightbill’s mom, at least not biologically. We see his differences, but up until he meets people who should be his community, he realizes them. I don’t think I stopped crying after that point and when I walked out of The Wild Robot, I didn’t know why. It took calling my mom and talking to a fellow critic who is also a stepchild to realize why. I had been Brightbill. I’m a brown-skinned Latina, and my dad is biracial and presents entirely as a white man. He’s my stepdad, but writing that, even saying that, just feels too detached. He’s just my dad. But being so different phenotypically, my cousins, my friends, and pretty much all of childhood were defined by people we knew and even strangers questioning our relationship. Was he my dad? Was I his daughter? Did it matter?\r\n\r\nRight now, parenthood by choice, those stepparents that walk into lives and step into spots that others left are being vilified. It’s being treated as a path of parenthood that is less than biological in terms of importance or validity. But in that space, The Wild Robot radically validates those of use with parents who chose us. It looks at our families and says, yes, you belong together. And that’s why I cried and kept crying until the film ended.\r\n\r\nThe Wild Robot may be one of Dreamwork’s most beautiful animated films, but more importantly, it’s the most emotionally salient. Every bit of the film feels necessary and every scene builds on the other. While you can take small moments and see their beauty out of context, The Wild Robot is meant to be viewed whole. In a cinematic time where it feels that more and more animated films by Western studios are built with curated TikTok clips in mind for viral marketing, this is one of the few times I have watched a major studio all ages animation and felt like I had returned to what made me fall in love with the medium.\r\n\r\nA true all-ages film, The Wild Robot sees even its youngest audiences as worthy of dramatic storytelling and dynamic emotions. It trusts them to understand the narrative without musical numbers or exposition. Instead, it immerses its audience, young and old, and makes you feel deeply for its characters. You can identify with Roz, Brightbill, and Fink. Or, you can even find yourself in the spaces in between. With a stunning cast of characters and performances that never felt phoned in or stunted for the star power, it reflected that my heart was bigger on the inside.\r\n\r\nFamily is what you make it, what it chooses it to be. The Wild Robot understands that nurture is stronger than nature and that our parents imprint on us as much as we do them. But more importantly, it doesn’t matter if we share our DNA. The Wild Robot solidifies the beauty and impact that Dreamworks has been delivering in animation. It’s the animation we need right now, and it feels like they know that.\r\n\r\nThe Wild Robot screened as a part of Fantastic Fest 2024 and is in theaters nationwide September 27, 2024.', 'img/articles/1761564002_arcane wallpaper.jpg', '2025-10-27 18:20:02', 10),
(4, 'Test', 'fadfadfadf', 'img/articles/1761564534_raffy cursed.jpg', '2025-10-27 18:28:54', 10),
(5, 'rr', 'rr', 'img/articles/1761569387_flower.PNG', '2025-10-27 19:49:47', 10);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `m_id` int(5) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `m_image` varchar(255) NOT NULL,
  `m_rating` float NOT NULL,
  `m_genre` enum('animation','action','horror','comedy','mystery','live action','series') NOT NULL,
  `m_desc` varchar(255) NOT NULL,
  `m_directed` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`m_id`, `m_name`, `m_image`, `m_rating`, `m_genre`, `m_desc`, `m_directed`) VALUES
(1, 'The Wild Robot', 'img/movie/wildRobot.png', 9.1, 'animation', 'After a shipwreck, an intelligent robot called Roz is stranded on an uninhabited island. To survive the harsh environment, Roz bonds with the islands animals and cares for an orphaned baby goose.', 'Chris Sanders'),
(2, 'The Lion King', 'img/movie/lionKing.png', 9.3, 'animation', 'Lion prince Simba and his father are targeted by his bitter uncle, who wants to ascend the throne himself.', 'Roger Allers and Rob Minkoff'),
(3, 'Weapons', 'img/movie/weapons.jpg', 8, 'horror', 'When all but one child from the same class mysteriously vanish on the same night at exactly the same time, a community is left questioning who or what is behind their disappearance.', 'Zach Cregger'),
(4, 'The Bad Guys 2', 'img/movie/badGuys2.jpg', 7.5, 'animation', 'The Bad Guys are struggling to find trust and acceptance in their newly minted lives as Good Guys, when they are pulled out of retirement and forced to do \"one last job\" by an all-female squad of criminals.', 'Pierre Perife and JP Sans'),
(5, 'The Beekeeper', 'img/movie/beekeeper.jpg', 6.5, 'action', 'A former operative of a powerful organization embarks on a brutal campaign for vengeance.', 'David Ayer'),
(6, 'Cars 2', 'img/movie/cars2.jpg', 9, 'animation', 'Star race car Lightning McQueen and his pal Mater head overseas to compete in the World Grand Prix race. But the road to the championship becomes rocky as Mater gets caught up in an intriguing adventure of his own: international espionage.', 'John Lasseter and Bradford Lewis'),
(7, 'Knives Out', 'img/movie/knivesOut.jpg', 7.8, 'mystery', 'When renowned crime novelist Harlan Thrombey is found dead at his estate just after his 85th birthday, the inquisitive and debonair Detective Benoit Blanc is mysteriously enlisted to investigate.', 'Rian Johnson'),
(8, 'Arcane', 'img/movie/arcane.jpg', 8.5, 'series', 'Amid the stark discord of twin cities Piltover and Zaun, two sisters fight on rival sides of a war between magic technologies and clashing convictions.', 'Pascal Charrue and Arnaud Delo'),
(9, 'Detective Conan : The Million-Dollar Pentagram', 'img/movie/detectiveConan24.jpg', 5.7, 'animation', 'The \"truth\" hidden in the sword cuts through the dark night and leads one under the moon. Love and incidents unfold in turbulent ways. The treasure battle mystery that will divide the world has begun.', 'Chika Nagaoka'),
(10, 'Ahsoka', 'img/movie/1761499972_ahsoka.jpeg', 8.4, 'series', 'After the fall of the Galactic Empire, former Jedi Ahsoka Tano investigates an emerging threat to a vulnerable galaxy.', 'Dave Filoni'),
(14, 'fadadfd', 'img/movie/1761569321_flower.PNG', 5.8, 'action', 'fff', 'fdadfa');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `r_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `m_id` int(5) NOT NULL,
  `review` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`r_id`, `user_id`, `m_id`, `review`) VALUES
(2, 5, 2, 'This is a film that can entertain anyone young or old, I usually don\'t care for animated movies but this film is the real deal, this is one of disney\'s best animated movies. The animation is top notch and flawless. This film also features superb work from the vocal cast James Earl Jones, Jeremy Irons, Whoopi Goldberg. This is a standout.'),
(3, 2, 2, 'This was a foundational text for little me - saw it multiple times theatrically to the point my dad just dropped me off at the Teaneck theater (3 bucks in those days) and watched it by myself for the first time - and back then as it still does today it manages to fill your belly in under 90 minutes with Mythical and even Mystical dimensions while also including Broadway stalwarts like Nathan Lane and Ernie Sabella singing about flatulence. It isn\'t enough to channel Hamlet or other sources (or e'),
(6, 6, 3, 'Weapons is a tense and gripping new horror from Zach Cregger that lives up to much of its immense hype. The story follows a community reeling after all but one child from the same class vanish on the same night at exactly the same time, and from there it unfolds with a sharp mix of mystery, dread, and dark humor. The acting across the board is phenomenal, the suspense is crafted with precision, and the world building for the small town setting feels rich and lived in. Practical effects shine, the score adds weight to the tension, and there are even moments of levity that break up the intensity without ever killing the mood.\r\nWhat makes Weapons stand out is how confidently it holds your attention. From start to finish, it\'s a film that refuses to let go, pulling you deeper into its unsettling premise. It\'s refreshing to see such commitment to originality in mainstream horror, and the movie feels like a love letter to the genre\'s willingness to take risks. While the final reveal of what truly happened may divide viewers, and for me personally, it didn\'t entirely stick the landing but the journey there is so compelling that it\'s hard not to walk away impressed.'),
(22, 8, 1, 'This movie is crazily gorgeous in all aspects, it\'s just crazy good for me and let me show you why\r\n\r\nFor the weakness however in this movie there is no mc like in puss in boots, no cool looking character like death, no magical ability or anything and yes this is a weakness because any body that try to watch that kind of movie will be disappointed but for me whose not searching for it will be satisfied.\r\n\r\nFrom the very beginning a robot and animals, very unique and creative compared to another and of course there are many life lessons and many emotional scene in this movie and dreamworks nailed it after failing in Kung Fu Panda 4.\r\n\r\nThis movie is simply really worth to watch, as long as you don\'t seek for those powerful mc and some popcorn movie you will be okay at least. In my opinion this movie is one of the best movie i have ever seen and i almost cry in the ending of this movie.'),
(23, 7, 1, 'I loved this movie.\r\n\r\nIt has a wonderful message of tolerance and unity. The voice acting is charming. The animation is very good, stunning at times. I liked the story, though I can see some people feeling it\'s too schmaltzy or corny.\r\n\r\nIn a world that is so divided, and a country that is seemingly hopelessly divided, it\'s very comforting to experience a story of characters coming together, being able to accept their differences, and building a community. Sadly, that\'s what makes it fiction too. But it\'s nice to dream.\r\n\r\nThe fact that the title character, and the character that inspires all the change, is the ultimate \"other\" only serves to make the point more elegantly.\r\n\r\nI suppose some people will think it\'s manipulative and needlessly tugs at the audience\'s heartstrings. But that\'s part of the beauty to me.\r\n\r\nI loved this movie.'),
(24, 6, 2, 'This is truly one of the best Disney movies ever. I really enjoyed it when I first seen it, about when I was 6, and since then I watched it over and over again. I simply LOOOOVED the music. It\'s one of the best soundtracks I\'ve ever heard. And, speaking of soundtrack, I just can\'t tell in words how much I love the song \"Can You Feel The Love Tonight\". Is one of my favorite songs ever. I truly believe that this motion picture could easily be nominated for The Best Picture, but The Best Song and the Best Original Score is really enough. I wonder if they will ever think to make a prequel of this movie in order to understand who is Mufasa, Scar, Sarabi and the other characters. In short, this movie will be remembered in the next 100 years. Truly.'),
(25, 5, 2, 'Watched the new one, and I think I had a disgusted look on my face the entire time. The music, the visuals, the dialogue, the voice acting, etc. Rewatched this one and remembered why this was my favorite Disney movie growing up. From mufasa\'s death to the goofy hyenas, to the bond between rafiki, simba and mufasa. The music that everyone knows every word to, and scar\'s ability to deliver each line perfectly. This movie is magic, the new one seems to tech focused and forgot what made lion king so beloved to begin with, its unfortunate. Hoping the circle of life makes it way around and the end of remakes draws close (see what I did there lol). Until then, lion king from the 90s will stay on my shelf and my kids will watch with me. This new one will never end up in my cart and I wont confuse my kids by watching it either. Thank you 90s Disney for the magic!'),
(27, 8, 3, 'Weapons delivers a bold and refreshing take on horror. The cinematography is sharp, the casting is spot-on, and the jump scares are genuinely effective. Major credit to the writers - they\'ve crafted a horror film that feels inventive and daring.\r\n\r\nDirector Zach Cregger continues to prove he\'s not afraid to break the mold, following up Barbarian (2022) with another unpredictable, non-traditional narrative. The story starts off familiar, but quickly evolves into something far more layered and unsettling.\r\n\r\nI especially appreciated the decision to split the narrative across multiple characters - it added depth and gave the audience a clearer view of the bigger picture.\r\n\r\nMy only real critique is the ending - it was a bit abstract and left me slightly unsatisfied. Still, it fits the film\'s overall tone and ambition.\r\n\r\nHighly recommended for fans of horror that challenges the norm.'),
(30, 7, 4, 'I saw The Bad Guys 2, starring the voices of Sam Rockwell-Argylle, Iron Man 2; Zazie Beetz-the Joker movies, Bullet Train; Danielle Brooks-A Minecraft Movie, Peacemaker_tv and Alex Borstein-Ted, Catwoman.\r\n\r\nThis is the sequel to the 2022 The Bad Guys movie and if you liked the first one, you\'ll really like this one. It\'s more of everything you liked and then some. Sam voices Wolf, the leader of the Bad Guys, who are trying to be good guys now. They can\'t find jobs though because of their past. Sam\'s girlfriend Zazie is now the governor who used to be a thief too, but turned herself around-no one knows about her past. When a new series of robberies make police chief Alex think Sam and company are bad guys again, the Bad Guys have to try and prove that they are innocent. Danielle plays the leader of a new all girl gang of criminals that blackmails Sam and company to do one last job. It\'s non stop action and entertainment for the whole family.\r\n\r\nIt\'s rated PG for action, violence, rude humor and language and has a running time of 1 hour & 44 minutes.\r\n\r\nI enjoyed it and would buy it on DVD.'),
(31, 6, 4, 'Now, I\'ll admit. The trailers, were not 100% doing it for me. I found it weird that they were doing a sequel about the bad guys, who are no longer bad? And the way the trailer showed us the bad girls, seems extremely forced in there. But I\'m pleased to say, that the trailers kind of miss marketed the movie. First off, it\'s more bad guys. If you like, what the first movie did. If you like these characters. The sequel delivers exactly what that first movie delivered on. The heist, the great character moments, the spy elements. Everything that makes that first movie as good as it is, is all in the sequel. And like I mentioned before, I was worried about the bad guys now being good, I thought making a sequel with them good, would make it feel like a forced sequel. But that is not the case at all, the movie goes down a certain direction that makes the plot work. But I\'m glad that we got a sequel now making them good people, because this movie would not have been the same thing without that plot line in there. That I am now excited and want more sequels based on these characters. I want to see a whole franchise built with them! This needs to be DreamWorks next big franchise they have because they can now do so many storylines with them. And since there\'s books on them, I expect that we will be getting that. Now, let\'s talk about the bad girls. The main part of this movie. And I gotta say, I love what they did with them. Throughout the entire movie I was just thinking about how great of villains they are, I haven\'t broke this fully down so I don\'t know 100% on how I would feel about it, but there\'s a chance that these villains are a top 10 DreamWorks villain. Take everything great about the bad guys but this time as a villain switching that perspective up. That\'s why they\'re such great villains. And I gotta say, I think this movie is better than the original. It\'s not by much, if you check my ranking is only a spot higher. It really only depends on my mood, but right now I'),
(32, 5, 5, 'Statham knows how to fight. The action is great.\r\n\r\nThe dialogs and the plot... oh my God. This was all written by a 15 year old as a weekend project.\r\n\r\nIt\'s all beyond ridiculous.\r\n\r\nEven Statham\'s usual delivery can\'t salvage the \"zinger\" phrases in this movie. Not even that.\r\n\r\nStill, the action is good.\r\n\r\nWatch it for the action. With beer. With friends around, making fun of all the silly and teenage-amateurish dialogs.\r\n\r\nYou\'ll walk out thinking that you should not have enjoyed this horrible movie, and that you can also be a Hollywood screenwriter. Easily.\r\n\r\nBy the way, they spent 40 million to do this... I can only imagine Statham walked out of the movie loaded.'),
(33, 4, 5, 'A solid popcorn action flick. Jason is his standard typecast role, which you can\'t blame him for, he\'s a one trick pony but that one trick is entertaining.\r\n\r\nThe whole movie is a budget-bin version of John Wick, which again is ok if you accept it for what it is.\r\n\r\nThe main down fall is the casting of Emmy Raver-Lampan, who is just a stunningly bad actress. It\'s impossible to believe her on onscreen, even in a popcorn flick.\r\n\r\nJeremy Irons is a welcome sight and lends credibility to the film, even though he doesn\'t get much screen time.\r\n\r\nDespite this I actually hope there\'s a sequel, fun action flicks are perfect beer and pizza viewing.'),
(34, 2, 6, 'It is true that this film is not like others Pixar films.But it is not acctualy so bad.Many review-writers is telling that this film is huge disappointment,and I think it is not true.I think that expectations was too big.\r\n\r\nSo,this is story about cars.About one friendship.They are completely different,but they are best friends.There is lot of nice,simple humor in the story.The scenario is \"smooth\" and it is easy watchable.There are much of action,surprises,cool techniques,like in James Bond. Yes,we could not expect that,but it is really OK .The characters are in many different places and they are meeting a different people.Characters are 3D,they have feelings and we feel empathy about them.\r\n\r\nBut,there is a \"dark side\" of film,which is not like Pixar.Enemies,propaganda and that stuff.These problems confuses and my 10 year old brother.It is not ugly or violent,it is just confusing to kids.\r\n\r\nAbout animation,I will not discuss.It is still Pixar;great animations and visuals and everything about it.\r\n\r\nThis is family film and it is really relaxing and enjoyable.Maybe sometimes is confusing,but it is not acctualy so bad.Because of action and messages that film gives: 7/10'),
(35, 8, 6, 'I keep reading reviews for Cars 2 and I am kind of surprised. Some people went as far as comparing it to the Star Wars prequels. Sure, Cars 2 definitely is no \"Finding Nemo\" or \"Toy Story.\" But it sure was fun, at least for me. The plot was an obvious reference to James Bond and Mission Impossible. I enjoyed the spy gadgets and political overtones. It was action-packed and not only enjoyable for little kids, but for older kids and adults too. Why all the hate? Heck, even Roger Ebert and Rolling Stone liked it!\r\n\r\nIn my opinion, Cars 1 was a little slow. It dragged a little too long in certain parts. Cars 2 suffers from no such thing.\r\n\r\nTo sum it up; Cars 2 may not be Toy Story but it sure is FUN and ENTERTAINING.'),
(36, 7, 7, 'Knives Out is really a classic story of it\'s kind set in modern day with Daniel Craig even playing a very clear Hercule Poirot type character. There\'s a bit more humor and self-awareness than a lot of those classic stories, but never to the degree that it takes away from the twists and the mysteries. And there are some good twists. In fact one of the biggest mysteries is revealed midway through the movie which actually led me to check the time thinking \"damn, are we near the end already?\" but nope, they were just taking the movie on a left turn to Albuquerque that I did not anticipate and changed the course of the whole thing. Johnson has constructed a great mystery in the spirit of the classics. The fun of it too is how many twists there are without it ever feeling overdone. In that way also you can predict a few twists, but not another, so have fun feeling smart and still feel surprised by the others. It\'s just a classic fun film of its type.'),
(37, 6, 7, 'No, it wasn\'t perfect. No it was not Academy Award material. But it was a delightful story with lots of classic whodunnit elements. I thought we got to know each character well and, like in an Agatha Christie novel, fulfilled their roles. I thought Craig did a nice job and kept things moving along. Plummer was good in his limited screen time. Once again, I\'m so fed up with people who decide that IMDB presents an opportunity to destroy a valid system by giving a movie such as this a rating of One. Do you really think this film ranks down there with Alligator Women on Venus. That\'s what the One ratings are for. It\'s usually because a film gets a little hype and those with no imagination or who are unhappy with their lives feel the need to throw everything off. Use lower ratings, but try to show some objectivity.'),
(38, 4, 8, 'This has no right being as good as it is. I mean, it\'s based on a video game, since when did that ever result in anything better than passable? But despite that this is one of the best shows I\'ve watched in a long time.\r\n\r\nI just saw the first episode of the new adaptation of the Wheel of time, and disappointed with that one I looked for something else and just happened to se that this was getting good reviews. It quickly grew on me and I binged the entire season in one sitting.\r\n\r\nArcane does everything right that so many shows and movies get wrong these days. They respect all of their characters, making sure that you understand why they do what they do and makes you sympathize with them. They take just the right amount of time to draw you in to the story and world before having major plotpoints happen, so that you really feel the impact of them. They set up things well in advance and makes sure to give you a proper payoff, so nothing feels rushed or cheap.\r\n\r\nAnd something that is oh so rare these days; they are not afraid to give all of their characters flaws and allowing them to fail, no matter their gender or how powerful they are supposed to be. This is a show with two female main characters that both can overpower anyone, and none of them feel like they haven\'t earned it. And not once do they feel the need to belittle men to show how cool they are. Pay attention, creators of other shows, this is how you write powerful characters, regardless of gender, that your audience can feel invested in.\r\n\r\nA special mention has to be given to the animators. Kudos to you for being able to make characters that can communicate both strong and subtle feelings clearer than most real actors are capable of. And also kudos to the choice of voice actors and music, both are top notch.\r\n\r\nAll in all a very enjoyable show that gives me a glimmer of hope for future entertainment, looking forward to season 2.'),
(39, 5, 8, 'I watched it with my parents who don\'t know anything about league\'s universe. I have been playing league since 2010, So my opinion may be a bit biased.\r\n\r\nBut my parents were pleasantly surprised. They said that sometimes it was a little clear that this series is more aimed at a young adult audience. Some usage of the pop songs, and the villian being a little over the top mustace twirly.\r\n\r\nBut overall they enjoyed the first 3 episodes and wouldn\'t mind watching the rest in their own time.\r\n\r\nAs for me. I loved it! It was everything I hoped for and then some. Riot\'s art department was always on their A game. And with the track record from Fortiche I knew this had very little chance to blunder.\r\n\r\nKnowing Riot\'s art department it has an excellent story, well written charaters and a lore rich world to take elements from. All in all, this show comes together very nicely. And shows some of the best talents Riot has to offer.\r\n\r\n9/10: Amazing.'),
(42, 8, 9, 'As someone who watched like 200 episodes in the series and some of the movies, the last i remembered is only the scarlet bullet and the submarine, i feel this movie has new approach comparing to those two, in a way i appreciate that but they messed a part\r\n\r\nFor me this movie has a different approach where things really get messy in the first hour, those sword fights and stuff really make me interested in the movie but in the act 2/3 the movie feel not enjoyable, no more unknown dead, basically no more trap it\'s just typical bomb and the main antagonist feels not really smart for killing only one men, because he could get away with several.\r\n\r\nBasically this movie having a really great first hour but not satisfying ending and another truth revealed which make me sure this series won\'t end until 2030. Well for me this is just another mid conan movie.'),
(43, 2, 9, 'What if a centuries-old legend, a phantom thief, and a string of cryptic murders converged in a deadly chase where history and greed intertwine? The Movie sets its stage with riddles carved into tradition and a treasure hunt that pushes both Conan and Kaitou Kid into a dangerous game of survival.\r\n\r\nThe plot follows a series of murders connected to an ancient treasure, with clues hidden in a star-shaped pattern-the \"pentagram.\" Kaitou Kid\'s involvement adds spectacle, yet the mystery grows darker as motives of revenge and greed unravel beneath the allure of riches. The film thrives on atmosphere, using historical references and cryptic codes to immerse the audience in a layered puzzle. The dynamic between Conan and Kid injects energy, balancing rivalry with reluctant cooperation.\r\n\r\nAnalytically, the film succeeds in evoking intrigue through its symbolic use of the pentagram, merging mystery with cultural and historical undertones. Themes of obsession, betrayal, and legacy resonate throughout, while the suspenseful treasure hunt sustains momentum. However, the narrative occasionally leans too heavily on spectacle, with the mystery\'s resolution less intricate than its buildup suggests. Supporting characters are underutilized, and the villain\'s motivations, while serviceable, lack the depth that could have elevated the story beyond a traditional treasure-quest framework.\r\n\r\nRating: 6/10 - visually engaging and thematically rich, The Million-dollar Pentagram entertains with its blend of codes, history, and rivalry, but its uneven mystery and reliance on spectacle keep it from shining as one of the series\' strongest entries.'),
(44, 6, 10, 'I actually enjoyed Ahsoka a lot more than I expected to. After reading all the mixed reviews I was expecting a slow moving, boring show but this was anything but. I was very entertained from the very first episode to the last. I was actually wanting more episodes when it was all ove he r. I know they\'re already talking about renewing this for another season so I hope they go through with that. The cast here is terrific. Obviously Rosario Dawson is great as Ahsoka but it\'s the supporting cast which makes this show that much better. It is extremely talented cast with Natasha Lou Bordizzo, Mary Elizabeth Winstead, Wes Chatham, David Tennant, the late great Ray Stevenson, and many more. You can tell they put a lot lot of love into this because the attention to detail is very obvious. While it\'s I not as good as the Mandalorian or Andor, it\'s still a good show in its own right.'),
(45, 1, 10, 'What I\'ve seen in the first two episodes is the definition of mediocracy. It\'s not bad, it\'s not good, just hanging somewhere in between.\r\n\r\nThe story so far is non-existent. There are some bad guys and... that\'s it.\r\n\r\nWriting is horrible. The character interactions were pretty much the most boring I\'ve seen in a very long time. It was painful to watch sometimes. It was that bad.\r\n\r\nForced wisdom... is the worst kind of writing.\r\n\r\nLogic has left the show. When I saw Sabine, one of the smartest fighters in the SW Universe, punching a robot in the face, I immediately lowered my expectations. After that, it even got worse. She\'s definitely NOT the Sabine I knew from the Rebel series.\r\n\r\nActing is also generally ... bland. Even Rosario Dawson seems off as Ahsoka.\r\n\r\nBut there are also good things.\r\n\r\nCGI and scenery are breathtaking.\r\n\r\nDavid Tenant is amazing as the voice of Huyang. God I love this man.\r\n\r\nThe show has some promise of mystery in the distant horizon, and that\'s what encourages me to watch more. If they can deliver, the show can get a lot better.'),
(46, 9, 4, 'film furry kesukaan ardi dan anak saya'),
(49, 4, 3, 'test'),
(50, 10, 2, 'halo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `fk_reviews_user` (`user_id`),
  ADD KEY `fk_reviews_movie` (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `m_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `r_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_movie` FOREIGN KEY (`m_id`) REFERENCES `movie` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
