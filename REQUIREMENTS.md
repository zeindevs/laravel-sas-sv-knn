# SAS-SV-KNN

## Input and Output

- Question

  - Q1: Missing planned work due to smartphone use
  - Q2: Having a hard time concentrating in class, while doing assignments, or while working due to smartphone use
  - Q3: Feeling pain in the wrists or at the back of the neck while using a smartphone
  - Q4: Won't be able to stand not having a smartphone
  - Q5: Feeling impatient and fretful when I am not holding my smartphone
  - Q6: Having my smartphone in my mind even when I am not using it
  - Q7: I will never give up using my smartphone even when my daily life is already greatly affected by it.
  - Q8: Constantly checking my smartphone so as not to miss conversations between other people on Twitter or Facebook
  - Q9: Using my smartphone longer than I had intended
  - Q10: The people around me tell me that I use my smartphone too much.

- Labels

  - L1: Strongly disagree | weight 1
  - L2: Disagree | weight 2
  - L3: Weakly disagree | weight 3
  - L4: Weakly agree | weight 4
  - L5: Agree | weight 5
  - L6: Strongly agree | weight 6

- Output

  - Addiction
  - Non addiction

## Table

- users

  - id integer
  - name varchar(100)
  - email varchar(100)
  - password varchar(100)
  - email_verified_at datetime
  - created_at datetime
  - updated_at datetime

- weights

  - id integer
  - name varchar(100)
  - weight integer()
  - created_at datetime
  - updated_at datetime

- questions

  - id integer
  - name varchar(100)
  - created_at datetime
  - updated_at datetime

- datasets

  - id integer
  - prediction varchar(100)
  - created_at datetime
  - updated_at datetime

- dataset_items

  - id integer
  - dataset_id integer
  - question_id integer
  - weight integer
  - created_at datetime
  - updated_at datetime

- submissions

  - id integer
  - name varchar(256)
  - prediction varchar(100)
  - created_at datetime
  - updated_at datetime

- submission_items

  - id integer
  - submission_id integer
  - question_id integer
  - weight_id integer
  - created_at datetime
  - updated_at datetime
