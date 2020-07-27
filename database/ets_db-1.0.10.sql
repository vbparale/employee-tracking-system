UPDATE 
  NXX_QUESTIONNAIRE 
SET 
  POSS_ANSWER = '{\r\n  \"1\": \"Alzheimer disease and dementia\",\r\n  \"2\": \"Arthritis\",\r\n  \"3\": \"Asthma\",\r\n  \"4\": \"Cancer\",\r\n  \"5\": \"Chronic obstructive pulmonary disease(COPD)\",\r\n  \"6\": \"Crohn disease\",\r\n  \"7\": \"Cystic fibrosis\",\r\n  \"8\": \"Diabetes\",\r\n  \"9\": \"Epilepsy\",\r\n  \"10\": \"Heart disease\",\r\n  \"11\": \"HIV/AIDS\",\r\n  \"12\": \"Mood disorders (bipolar, cyclothymic, and depression)\",\r\n  \"13\": \"Multiple sclerosis\",\r\n  \"14\": \"Parkinson disease\",\r\n  \"15\": \"None\",\r\n  \"16\": \"Other\"\r\n}' 
WHERE 
  TRANSACTION = 'HDFHH' 
  AND SEQUENCE = 5;

UPDATE 
  NXX_QUESTIONNAIRE 
SET 
  QUESTION = 'Did you have any close contact with positive CoViD Person and/or Person Under Investigation (PUI)?' 
WHERE 
  `QCODE` = 5 
  AND TRANSACTION = 'EHC';