import pandas as pd


df = pd.read_csv('books.csv', on_bad_lines='skip')


df['publication_date'] = pd.to_datetime(df['publication_date'], errors='coerce').dt.strftime('%Y-%m-%d')


df.to_csv('books_mysql_date.csv', index=False)

