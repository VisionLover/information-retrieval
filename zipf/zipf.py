from hazm import word_tokenize
import mysql.connector
import numpy as np
import matplotlib.pyplot as plt
from sklearn.linear_model import LinearRegression
from collections import Counter

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="searching"
)

# PREPROCESSING
mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM records")
myresult = mycursor.fetchall()
words = []
for d in myresult:
    words.extend(word_tokenize(d[2]))

# HEAPS LAW
M = [0] #the number of tokens
T = [0] #the vocabulary size
vocab_set = set()
for d in myresult:
    wlist = word_tokenize(d[2])
    M.append(M[-1] + len(wlist))
    vocab_set.update(wlist)
    T.append(len(vocab_set))
x = np.log(T[1:])
y = np.log(M[1:])
plt.plot(x,y)
X = x.reshape(len(x),1)
lr = LinearRegression().fit(X,y)
plt.plot(x, lr.predict(X), 'r')
plt.show()
print("heaps law: ",lr.coef_)

# zipfs law
counts = Counter(words)
L = counts.most_common()
cf = [l[1] for l in L]
x = np.log(range(1,len(L)+1))
y = np.log(cf)
plt.plot(x,y)
X = x.reshape(len(x),1)
lr = LinearRegression().fit(X,y)
plt.plot(x,lr.predict(X), 'r')
print("zipfs law: ",lr.coef_)
plt.show()