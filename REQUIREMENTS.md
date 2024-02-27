# SAS-SV-KNN

## Input and Output

- Labels
  - Strongly disagree | weight 1
  - Disagree | weight 2
  - Weakly disagree | weight 3
  - Weakly agree | weight 4
  - Agree | weight 5
  - Strongly agree | weight 6

## Table

- users

  - id
  - name
  - email
  - password
  - email_verified_at
  - created_at
  - updated_at

- weights

  - id
  - name
  - weight
  - created_at
  - updated_at

- questions

  - id
  - name
  - created_at
  - updated_at

- datasets

  - id
  - prediction
  - created_at
  - updated_at

- dataset_items

  - id
  - dataset_id
  - question_id
  - weight
  - created_at
  - updated_at

- submissions

  - id
  - name
  - prediction
  - created_at
  - updated_at

- submission_items

  - id
  - submission_id
  - question_id
  - weight_id
  - created_at
  - updated_at
