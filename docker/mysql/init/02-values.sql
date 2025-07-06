USE phpapp;

-- --
-- INSERT USERS
-- --
INSERT INTO users (name, email, hashed_password, role) VALUES ('Kendrick', 'klamar@ucsc.edu', '$2a$12$kOUk2PKoWY9T8ZuCnNqGne.OiNiwYssvNKsbgtPOfKbLUTjcJftgi', 'USER');
SET @kId = LAST_INSERT_ID();

INSERT INTO users (name, email, hashed_password, role) VALUES ('admin', 'admin@ucsc.edu', '$2a$12$mpWh2rtFp4IecmD.rYwfR.cFVR87EddlrSbu6JNIxQKvrmAIr9AEu', 'ADMIN');
SET @adminId = LAST_INSERT_ID();
-- --
-- INSERT USER META
-- --
INSERT INTO user_meta (uid) VALUES @kId;
INSERT INTO user_meta (uid) VALUES @adminId;

-- --
-- INSERT BANK INFO
-- --
INSERT INTO banks (uid, name, type) VALUES (@kId, 'Bank of America', 'CREDIT');
SET @kBofAId = LAST_INSERT_ID();

INSERT INTO banks (uid, name, type) VALUES (@adminId, 'Chase', 'DEBIT');
SET @adminBank = LAST_INSERT_ID();

-- --
-- INSERT BUDGETS
-- --
SELECT @firstOfTheMonth := CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE);
SET @lastOfTheMonth = LAST_DAY(@firstOfTheMonth);

INSERT INTO budgets (uid, name, max_amount, from_date, to_date) VALUES (@kId, 'Current Budget', 900.50, @firstOfTheMonth, @lastOfTheMonth);
SET @kBudget = LAST_INSERT_ID();

INSERT INTO budgets (uid, name, max_amount, from_date, to_date) VALUES (@adminId, 'Avaris Budget', 100.23, @firstOfTheMonth, @lastOfTheMonth);
SET @adminBudget = LAST_INSERT_ID();

-- --
-- INSERT TRANSACTIONS
-- --
INSERT INTO transactions (uid, bid, name, amount, type, category) VALUES (@kId, @kBofAId, '1996 Chrysler Town & Country', 25906.34, 'EXPENSE', 'TRANSPORTATION');
INSERT INTO transactions (uid, bid, name, amount, description, type, category, budget_id) VALUES (@kId, NULL, 'Canadian Tuxedo', 902.39, 'Say Drake...', 'EXPENSE', 'SHOPPING', @kBudget);
INSERT INTO transactions (uid, bid, name, amount, description, type, category, budget_id) VALUES (@kId, @kBofAId, 'Don\'t worry about it', 8931.43, 'A second of just saying hi to people', 'INCOME', NULL, NULL);

INSERT INTO transactions (uid, bid, name, amount, description, type, category, budget_id) VALUES (@adminId, @adminBank, 'Hosting Server', 90.23, 'Monthly cost', 'EXPENSE', 'BILLS', @adminBudget);
INSERT INTO transactions (uid, bid, name, amount, description, type, category, budget_id) VALUES (@adminId, NULL, 'Water', 2.34, NULL, 'EXPENSE', 'GROCERIES', NULL);
INSERT INTO transactions (uid, bid, name, amount, description, type, category, budget_id) VALUES (@adminId, @adminBank, 'Payroll', 100.32, NULL, 'INCOME', NULL, NULL);