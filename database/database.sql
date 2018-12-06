CREATE TABLE User (
    user_id     INTEGER PRIMARY KEY,
    username    TEXT NOT NULL UNIQUE,
    password    TEXT NOT NULL
);

CREATE TABLE Message (
    message_id  INTEGER PRIMARY KEY,
    title       TEXT NOT NULL,
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
    creator_id  INTEGER REFERENCES User(user_id)     
);

CREATE TABLE ChannelSubscribers (
    channel_id  INTEGER NOT NULL,
    user_id     INTEGER NOT NULL,
    PRIMARY KEY (channel_id, user_id)
);


CREATE TABLE ChannelMessages (
    channel_id  INTEGER NOT NULL,
    story_id    INTEGER NOT NULL REFERENCES Message(message_id),
    PRIMARY KEY (channel_id, story_id)
);






-- Insert info

-- Users
INSERT INTO User VALUES (null, 'User1', 'Password');
INSERT INTO User VALUES (null, 'User2', 'Password');
INSERT INTO User VALUES (null, 'User3', 'Password');

-- Messages
INSERT INTO Message VALUES 
(null, 
'1. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan.',
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac diam ornare justo fringilla accumsan. Donec vestibulum nulla sit amet lacus sagittis, ac dignissim mi faucibus. Integer cursus eleifend turpis iaculis porttitor. Maecenas maximus ante a metus dictum tempus. Praesent quis ante vel sem vulputate varius. Nullam cursus sagittis nunc et luctus. Quisque tincidunt urna eget dolor auctor, eu porttitor mauris varius. Pellentesque accumsan neque lectus, ac pellentesque augue cursus ut. Praesent ac neque dui. Nunc dui nisi, placerat ut mollis et, varius id quam.',
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


-- Channels

INSERT INTO Channel VALUES (null, 'Channel1', 1);
INSERT INTO Channel VALUES (null, 'Channel2', 1);
INSERT INTO Channel VALUES (null, 'Channel3', 1);
INSERT INTO Channel VALUES (null, 'Channel4', 1);
INSERT INTO Channel VALUES (null, 'Channel5', 1);
INSERT INTO Channel VALUES (null, 'Channel6', 1);
INSERT INTO Channel VALUES (null, 'Channel7', 1);


-- Channel Messages

INSERT INTO ChannelMessages VALUES(1, 1);
INSERT INTO ChannelMessages VALUES(3, 2);


CREATE TRIGGER update_score_insert
BEFORE INSERT ON Vote
WHEN (NOT EXISTS (SELECT * FROM Vote WHERE message_id = new.message_id AND user_id = new.user_id))
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