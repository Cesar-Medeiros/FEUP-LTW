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
    WHERE channel_id = new.channel_id;
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
'1. Symbol',
'Any transmitted robot cooperates beneath the symbol. When can his pork rot? Why can´t the sacked mug boggle? The irony writes. When can a breeding parrot highlight the matrix?',
1543759793,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'2. Soundtrack',
'A shoe toes the line beneath a cultural kingdom. The repaired jerk releases the cricket. The perpetual passport decides in the diary. The voluntary expert adjusts the lemon on top of the lined gang. When can my husband portion the soundtrack?',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'3. Lemon',
'The lemon mocks the bomb in the liberal creed. An engaged mirror smiles. A fooling cathedral tends an incorporated missile. This best beard explodes without the void.',
1543759773,
0,
0,
1,
null
);


INSERT INTO Message VALUES 
(null, 
'4. Vegetable',
'Around a vegetable crawls a bass crossroad. Above the hollow headline chews an essential egg. The laugh accepts. The warmed supernatural joins an amber sexist. The butter scores. A misprint reads?',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'5. Grandmother',
'The explosive coasts into the monarch! The careful lad advertises. How does the sequel strain before the automatic cap? The virtue stretches underneath the urge! Can an amazing grandmother gut his kettle?',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'6. Accountant',
'Every open accountant farms before the tenth percentage. The wonderful carrot resumes a winning doctrine. A medium voter jokes. Why can´t the tube foul the expensive cliff?',
1543759773,
0,
0,
1,
null
);
INSERT INTO Message VALUES 
(null, 
'7. League',
'A mandate cruises without any finger. Can a contour revenge the acquaintance? The shared rival bicycles past whatever bug. The anomaly dashes over a beneficial grandmother. A switch bite spits beside the devious civilian. A jam clogs over a special worry.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'8. Roof',
'The naming contour reckons the gratuitous agenda. A noble accent speculates. The stuck roof landscapes a defensive forecast. The disguise aces the vegetable inside a disgusted code.',
1543759773,
0,
0,
1,
null
);


INSERT INTO Message VALUES 
(null, 
'9. Game',
'The march reasons. How does the western pose? When will the bulb reign throughout the advisory manufacturer? His heritage talks throughout a drill. A negligible industry fudges with a game.',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'10. Surgery',
'The overseas tangent bores against a connector. The acorn stages each annual bird. Why can't the suspected significance pump? Why can't the telling steer portray our surgery?',
1543759773,
0,
0,
1,
null
);

INSERT INTO Message VALUES 
(null, 
'11. Monkey',
'An extremist trap persists in a waste. How can a trace appall the planned prejudice? My nonsense spike fries the spike. A doctor experiments with the monkey inside the upright protest.',
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
'13. Pencil',
'A generator neglects a quest. Below the artist exists the explanatory island. The sport deals the revolutionary outside the discarded matrix. Its cinema champions a nest opposite the interesting pencil. Any python impresses the illiterate.',
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
'Completely nonsense.',
1543759773,
0,
0,
1,
1
);

INSERT INTO Message VALUES 
(null, 
null,
'Very nice indeed!',
1543759773,
0,
0,
1,
1
);

INSERT INTO Message VALUES 
(null, 
null,
'LOL',
1543759773,
0,
0,
1,
13
);



-- Channels

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

INSERT INTO Vote VALUES(1, 1, 1);
INSERT INTO Vote VALUES(2, 1, 1);
INSERT INTO Vote VALUES(3, 1, 1);
INSERT INTO Vote VALUES(2, 2, 1);
INSERT INTO Vote VALUES(1, 2, 1);
INSERT INTO Vote VALUES(3, 3, 1);
