import pandas as pd
import numpy as np
import matplotlib.pyplot as plt

data = pd.read_csv("D:\Practice dev\Python\loan_data_set.csv")
# print(data.head())
# print(data.shape)
# print(data.info())

# print(data.isnull().sum())
# print(data.isnull().sum()*100 / len(data))

## Handling Missing values
data = data.drop('Loan_ID',axis=1)
columns = ['Gender','Dependents','LoanAmount','Loan_Amount_Term']
data = data.dropna(subset=columns)
data['Self_Employed'] =data['Self_Employed'].fillna(data['Self_Employed'].mode()[0])

data['Credit_History'] =data['Credit_History'].fillna(data['Credit_History'].mode()[0])

# print(data.isnull().sum()*100 / len(data))

## Handling Missing Values

# print(data.sample(5))

data['Dependents'] =data['Dependents'].replace(to_replace="3+",value='4')

# print(data['Dependents'].unique())

# print(data['Loan_Status'].unique())

data['Gender'] = data['Gender'].map({'Male':1,'Female':0}).astype('int')
data['Married'] = data['Married'].map({'Yes':1,'No':0}).astype('int')
data['Education'] = data['Education'].map({'Graduate':1,'Not Graduate':0}).astype('int')
data['Self_Employed'] = data['Self_Employed'].map({'Yes':1,'No':0}).astype('int')
data['Property_Area'] = data['Property_Area'].map({'Rural':0,'Semiurban':2,'Urban':1}).astype('int')
data['Loan_Status'] = data['Loan_Status'].map({'Y':1,'N':0}).astype('int')

# print(data.head())

## Store Feature Matrix In X And Response (Target) In Vector y

X = data.drop('Loan_Status',axis=1)
y = data['Loan_Status']

## Feature Scaling

cols = ['ApplicantIncome','CoapplicantIncome','LoanAmount','Loan_Amount_Term']
from sklearn.preprocessing import StandardScaler
st = StandardScaler()
X[cols]=st.fit_transform(X[cols])

from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score
from sklearn.metrics import accuracy_score


model_df={}
def model_val(model,X,y):
    X_train,X_test,y_train,y_test=train_test_split(X,y,test_size=0.20,random_state=42)
    model.fit(X_train,y_train)
    y_pred=model.predict(X_test)
    print(f"{model} accuracy is {accuracy_score(y_test,y_pred)}")
    
    score = cross_val_score(model,X,y,cv=5)
    print(f"{model} Avg cross val score is {np.mean(score)}")
    model_df[model]=round(np.mean(score)*100,2)

## Random forest classifier

from sklearn.ensemble import RandomForestClassifier
model =RandomForestClassifier()
# model_val(model,X,y)


## Hyperparameter tuning

# from sklearn.model_selection import RandomizedSearchCV
# rf_grid={'n_estimators':np.arange(10,1000,10),
#   'max_features':['auto','sqrt'],
#  'max_depth':[None,3,5,10,20,30],
#  'min_samples_split':[2,5,20,50,100],
#  'min_samples_leaf':[1,2,5,10]
#  }

# rs_rf=RandomizedSearchCV(RandomForestClassifier(),param_distributions=rf_grid,cv=5,n_iter=20)

# rs_rf.fit(X,y)

# print(rs_rf.best_score_)

# RandomForestClassifier score Before Hyperparameter Tuning: 77.76
# RandomForestClassifier score after Hyperparameter Tuning: 80.66 

## Saving the model

rf = RandomForestClassifier(n_estimators=270,
 min_samples_split=5,
 min_samples_leaf=5,
 max_features='sqrt',
 max_depth=5)


rf.fit(X,y)

import pickle
pickle.dump(rf, open('loan_pred.pkl','wb'))
