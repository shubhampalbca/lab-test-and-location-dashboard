# Laravel Dependent Dropdown & Lab Test Management System

This project implements two key dynamic dependent dropdown features using Laravel. It utilizes Bootstrap 5 to deliver a clean, professional, two-column dashboard layout where data entry takes place on the left and live recorded data renders instantly on the right.

---

## 🚀 Main Features

1. **Location Management Dashboard (Country ➔ State ➔ City)**
   - Uses jQuery AJAX to dynamically fetch relational data without reloading the page.
   - Designed with a dual-column layout (Left: Input Form, Right: Live Entries Table).
   - Records data instantly into the database and pulls human-readable names using SQL Joins.

2. **Lab Test Management System (Department ➔ Parent Lab Tests)**
   - Dynamically loads specific laboratory tests when a department is selected.
   - Supports multi-test array injection, using a `foreach` loop to process and save bulk test mappings efficiently via Eloquent.

---

## 🗄️ Database Structure

Ensure your database contains the following tables and schemas to run both modules successfully:

### 1. Location Dashboard Tables
* **`countries`**: `id`, `name`
* **`states`**: `id`, `name`, `country_id`
* **`cities`**: `id`, `name`, `state_id`
* **`dropdouns`** (Primary data logging table):
  ```sql
  id (INT, Primary Key, Auto Increment)
  name (VARCHAR, Entry Title/Description)
  country_id (INT)
  state_id (INT)
  city_id (INT)
  created_at / updated_at (TIMESTAMP)