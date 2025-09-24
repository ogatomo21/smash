CREATE TABLE IF NOT EXISTS smash_data (
    data_id TEXT PRIMARY KEY NOT NULL,
    data_content TEXT DEFAULT NULL,
    latest_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT OR IGNORE INTO smash_data (data_id) VALUES ('temperature');
INSERT OR IGNORE INTO smash_data (data_id) VALUES ('humidity');
INSERT OR IGNORE INTO smash_data (data_id) VALUES ('lock_state');
INSERT OR IGNORE INTO smash_data (data_id) VALUES ('lock_battery');
