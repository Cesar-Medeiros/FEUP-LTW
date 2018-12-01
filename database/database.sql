CREATE TABLE User (
    user_id     INTEGER PRIMARY KEY,
    username    TEXT NOT NULL UNIQUE,
    password    TEXT NOT NULL
);

CREATE TABLE Story (
    story_id    INTEGER PRIMARY KEY,
    title       TEXT NOT NULL,
    message_id  INTEGER NOT NULL REFERENCES Message(message_id)
);

CREATE TABLE Comment (
    comment_id  INTEGER PRIMARY KEY,
    message_id  INTEGER NOT NULL REFERENCES Message(message_id)
);


CREATE TABLE Message (
    message_id  INTEGER PRIMARY KEY,
    text        TEXT NOT NULL,
    date        INTEGER NOT NULL,
    score       INTEGER,
    comments    INTEGER,
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
    story_id    INTEGER NOT NULL REFERENCES Story(story_id),
    PRIMARY KEY (channel_id, story_id)
);

CREATE TRIGGER insert_user
AFTER INSERT ON USER
BEGIN
    UPDATE USER SET user_id = (SELECT max(user_id) from USER) + 1
    WHERE username = NEW.username;
END;