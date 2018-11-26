CREATE TABLE User(
    user_id     INTEGER PRIMARY KEY,
    username    TEXT NOT NULL UNIQUE,
    password    TEXT NOT NULL
);

CREATE TABLE Story(
    story_id    INTEGER PRIMARY KEY,
    title       TEXT NOT NULL,
    text        TEXT NOT NULL,
    date        TEXT NOT NULL,
    score       INTEGER,
    comments    INTEGER,
    publisher   INTEGER NOT NULL REFERENCES User(user_id)
);

CREATE TABLE Comment(
    comment_id  INTEGER PRIMARY KEY,
    text        TEXT NOT NULL,
    date        TEXT NOT NULL,
    score       INTEGER,
    comments    INTEGER,
    publisher   INTEGER NOT NULL REFERENCES User(user_id),
    
    story_parent_id    INTEGER REFERENCES Story(story_id),
    comment_parent_id  INTEGER REFERENCES Comment(comment_id)
);


CREATE TABLE VoteStory(
    user_id     INTEGER NOT NULL REFERENCES User(user_id),
    story_id  INTEGER NOT NULL REFERENCES Story(story_id),
    vote        INTEGER NOT NULL DEFAULT 0 CHECK (vote = -1 OR vote = 0 OR vote = 1),
    PRIMARY KEY (user_id, story_id)
);

CREATE TABLE VoteComment(
    user_id     INTEGER NOT NULL REFERENCES User(user_id),
    comment_id  INTEGER NOT NULL REFERENCES Comment(comment_id),
    vote        INTEGER NOT NULL DEFAULT 0 CHECK (vote = -1 OR vote = 0 OR vote = 1),
    PRIMARY KEY (user_id, comment_id)
);
