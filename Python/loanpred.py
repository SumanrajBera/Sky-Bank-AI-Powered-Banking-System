import pickle as pkl
import sys

with open('loan_pred.pkl','rb') as f:
    model = pkl.load(f)

import pandas as pd
df = pd.DataFrame({
    'Gender': sys.argv[1], #1 d
    'Married':sys.argv[2], #1 d
    'Dependents':sys.argv[3],#2 d
    'Education':sys.argv[4],#0 d
    'Self_Employed':sys.argv[5],#0 d
    'ApplicantIncome':sys.argv[6],#2889 d
    'CoapplicantIncome':sys.argv[7],#0.0 d
    'LoanAmount':sys.argv[8],#45 
    'Loan_Amount_Term':sys.argv[9],#180 n
    'Credit_History':sys.argv[10],#0 n
    'Property_Area':sys.argv[11] #1
},index=[0])

result = model.predict(df)
if result==1:
    print("Loan Approved")
else:
    print("Loan Not Approved")
