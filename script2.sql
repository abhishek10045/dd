USE event_details;

CREATE TABLE event5 (
    id INT UNSIGNED UNIQUE NOT NULL,
    FOREIGN KEY(id) REFERENCES users(id)    
);