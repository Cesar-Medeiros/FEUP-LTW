CREATE TABLE User (
    user_id     INTEGER PRIMARY KEY,
    username    TEXT NOT NULL UNIQUE,
    password    TEXT NOT NULL,
    email       TEXT NOT NULL UNIQUE
);

CREATE TABLE Message (
    message_id  INTEGER PRIMARY KEY,
    title       TEXT,
    text        TEXT NOT NULL,
    date        INTEGER NOT NULL,
    score       INTEGER NOT NULL,
    comments    INTEGER NOT NULL,
    publisher   INTEGER NOT NULL REFERENCES User(user_id),
    parent_message_id  INTEGER REFERENCES Message(message_id)
);


CREATE TABLE Vote (
    user_id     INTEGER NOT NULL REFERENCES User(user_id),
    message_id  INTEGER NOT NULL REFERENCES Message(message_id),
    vote        INTEGER NOT NULL DEFAULT 0 CHECK (vote = -1 OR vote = 0 OR vote = 1),
    PRIMARY KEY (user_id, message_id)
);

CREATE TABLE Channel (
    channel_id  INTEGER PRIMARY KEY,
    title       TEXT NOT NULL,
    creator_id  INTEGER REFERENCES User(user_id),
    num_subscribers INTEGER NOT NULL DEFAULT 0,
    num_posts INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE ChannelSubscribers (
    channel_id  INTEGER NOT NULL,
    user_id     INTEGER NOT NULL,
    PRIMARY KEY (channel_id, user_id)
);


CREATE TABLE ChannelMessages (
    channel_id  INTEGER NOT NULL,
    message_id    INTEGER NOT NULL REFERENCES Message(message_id),
    PRIMARY KEY (channel_id, message_id)
);


CREATE TRIGGER update_score_insert
BEFORE INSERT ON Vote
-- WHEN (NOT EXISTS (SELECT * FROM Vote WHERE message_id = new.message_id AND user_id = new.user_id))
BEGIN
    UPDATE Message
    SET score = score + new.vote
    WHERE message_id = new.message_id;
END;


CREATE TRIGGER update_score_update
BEFORE UPDATE ON Vote
BEGIN
    UPDATE Message
    SET score = score - old.vote + new.vote
    WHERE message_id = new.message_id;
END;


CREATE TRIGGER update_score_delete
BEFORE DELETE ON Vote
BEGIN
    UPDATE Message
    SET score = score - old.vote
    WHERE message_id = old.message_id;
END;



CREATE TRIGGER one_more_subcriber
BEFORE INSERT ON ChannelSubscribers
BEGIN
    UPDATE Channel
    SET num_subscribers = num_subscribers + 1
    WHERE channel_id = new.channel_id;
END;

CREATE TRIGGER one_less_subcriber
BEFORE DELETE ON ChannelSubscribers
BEGIN
    UPDATE Channel
    SET num_subscribers = num_subscribers - 1
    WHERE channel_id = old.channel_id;
END;


CREATE TRIGGER update_comment_number
AFTER INSERT ON Message
WHEN new.parent_message_id is NOT NULL
BEGIN
    UPDATE Message
    SET comments = comments + 1
    WHERE message_id = new.parent_message_id;
END;












-- Insert info

-- Users
INSERT INTO User VALUES (null, 'User1', 'Password', 'user1@email.com');
INSERT INTO User VALUES (null, 'User2', 'Password', 'user2@email.com');
INSERT INTO User VALUES (null, 'User3', 'Password', 'user3@email.com');

-- Messages
INSERT INTO Message VALUES 
(null, 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel ipsum non ante volutpat tempus. Donec mattis erat ac urna sodales, ac tempor massa tempor. Donec non nulla felis. Nunc auctor, odio id mattis volutpat, felis leo vestibulum elit, vitae mollis ex neque nec sem. Proin at fermentum orci. Integer sagittis nisi id nisl pellentesque, sit amet fringilla est ullamcorper. Sed feugiat erat molestie dui finibus, ut congue magna porttitor. Mauris sit amet nisl sit amet lorem rutrum tristique eget vel quam.

Cras varius dignissim purus nec euismod. Etiam a maximus lorem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla facilisi. Nunc auctor volutpat lectus, vel mattis mi scelerisque nec. Mauris convallis quis dolor sit amet suscipit. Nullam sagittis volutpat urna, eget ultricies ante accumsan et. Nunc euismod turpis sed elit vehicula ultrices. Quisque dui sem, vestibulum in auctor ac, feugiat ut nisl. Aenean sit amet pellentesque sem, quis blandit eros.

Aliquam sit amet elit porta, aliquam ligula vitae, eleifend quam. Praesent quis ipsum tincidunt quam vulputate euismod. Cras quis aliquet neque. Praesent vel enim dui. Nullam purus dolor, luctus a magna vitae, cursus dignissim lectus. Aliquam ultricies suscipit ex. Aliquam finibus magna nisl, vitae sodales eros fermentum sit amet. Nam quis leo non risus dapibus pellentesque non at mauris. Aenean ac accumsan nulla. Suspendisse et blandit ipsum. Suspendisse condimentum ante sem, eu rhoncus est sodales ut.

Nullam et libero ligula. Phasellus nunc lorem, egestas non imperdiet vel, scelerisque vitae augue. In vestibulum lacus non lacinia fermentum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean facilisis feugiat venenatis. Sed porttitor iaculis tortor, id finibus purus blandit ut. Fusce gravida, lectus non tempus semper, est metus rhoncus dolor, a ornare purus enim in massa. Duis iaculis tortor at neque egestas posuere vel tempor mi. Duis laoreet velit orci, et consequat diam dapibus nec. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi et eros a mi blandit porta. Suspendisse quis hendrerit velit, non scelerisque mauris. Mauris accumsan sapien turpis, in vulputate nulla venenatis a. Nulla id purus ligula. Aliquam erat volutpat. Vivamus malesuada, odio vitae sagittis sollicitudin, lorem augue viverra nisi, ac consequat eros enim ac dolor.

Etiam quam metus, congue ut condimentum sed, fringilla id eros. Suspendisse quis maximus velit. Suspendisse mattis libero in urna cursus eleifend. Proin faucibus diam ut efficitur dictum. Pellentesque tellus felis, porta nec gravida ut, dignissim sed purus. Ut sollicitudin iaculis erat, nec cursus velit imperdiet molestie. Cras eget lorem urna. Ut venenatis purus non elit accumsan rhoncus. Nullam auctor elit ante, vitae pulvinar magna porta interdum. Ut vel nibh aliquam, ullamcorper magna vel, congue mauris. Nullam eu libero in urna commodo tempus tristique vel mauris. Sed ac bibendum nisl. Aliquam pulvinar nulla nunc, ornare consequat eros lobortis ac. Nulla at arcu ultricies, rutrum arcu sit amet, volutpat arcu. Donec sed lorem in nibh molestie egestas ac in magna.',
1543759793,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'2. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'3. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);


INSERT INTO Message VALUES 
(null, 
'4. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'5. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'6. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);
INSERT INTO Message VALUES 
(null, 
'7. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'8. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);


INSERT INTO Message VALUES 
(null, 
'9. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'10. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'11. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'12. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'13. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
1543759773,
0,
0,
1,
null
);

-- Comments


INSERT INTO Message VALUES 
(null, 
null,
'Comment1: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
1543759773,
0,
0,
1,
1
);

INSERT INTO Message VALUES 
(null, 
null,
'Comment2: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
1543759773,
0,
0,
1,
1
);

INSERT INTO Message VALUES 
(null, 
null,
'SubComment: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
1543759773,
0,
0,
1,
15
);



-- Channels

INSERT INTO Channel VALUES (0, ' ', 0, 0, 0);
INSERT INTO Channel VALUES (null, 'Channel1', 1, 0, 0);
INSERT INTO Channel VALUES (null, 'Channel2', 1,0 ,0);
INSERT INTO Channel VALUES (null, 'Channel3', 1,0 ,0);
INSERT INTO Channel VALUES (null, 'Channel4', 1,0 ,0);
INSERT INTO Channel VALUES (null, 'Channel5', 1,0 ,0);
INSERT INTO Channel VALUES (null, 'Channel6', 1,0 ,0);
INSERT INTO Channel VALUES (null, 'Channel7', 1,0 ,0);


-- Channel Messages

INSERT INTO ChannelMessages VALUES(1, 1);
INSERT INTO ChannelMessages VALUES(3, 2);
INSERT INTO ChannelMessages VALUES(3, 3);
INSERT INTO ChannelMessages VALUES(3, 4);
INSERT INTO ChannelMessages VALUES(3, 5);
INSERT INTO ChannelMessages VALUES(3, 6);
INSERT INTO ChannelMessages VALUES(3, 7);
INSERT INTO ChannelMessages VALUES(3, 8);
INSERT INTO ChannelMessages VALUES(3, 9);
INSERT INTO ChannelMessages VALUES(3, 10);
INSERT INTO ChannelMessages VALUES(3, 11);
INSERT INTO ChannelMessages VALUES(3, 12);
INSERT INTO ChannelMessages VALUES(3, 13);

--Channel Subscribers
INSERT INTO ChannelSubscribers VALUES(3, 1);
