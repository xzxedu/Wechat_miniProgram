import numpy as np
import pandas as pd
import seaborn as sns
import struct
import pymysql
import pymysql.cursors
import matplotlib.pyplot as plt
from sklearn.model_selection import train_test_split

def sigmoid(z):
    p = 1.0 / (1+np.exp(-z))
    return p

def loadData(user, password, db, table, port = 3306):
    """
       fetch data from mysql database, return as dataframe
    """
    db = pymysql.connect(host = 'localhost',
                         user = user,
                         password = password,
                         db = db,
                         port = port,
                         charset = 'utf8')

    cur = db.cursor()

    sql = "select * from %s" %table
    try:
        cur.execute(sql) 
        results = cur.fetchall()
        data  = pd.DataFrame(list(results))
        
        # Get name of each feature in mysql
        data.columns = np.asarray(cur.description)[:, 0]
        
        # Convert decimal.Decimal to float
        data['Income'] = data['Income'].map(lambda x: float(x))

        data['Debt'] = data['Debt'].map(lambda x: float(x))

        # convert bytes into binary(1 and 0)
        data['Borrow'] = data['Borrow'].map(lambda x: int.from_bytes(x, 
                                                                     byteorder = 'little',
                                                                     signed = True) - 48)
        data['Repay'] = data['Repay'].map(lambda x: int.from_bytes(x,  
                                                                   byteorder = 'little', 
                                                                   signed = True) - 48)
        return data

    except Exception as e:
        raise e

    finally:
        db.close()



def splitData(data):
    """
       Split data into train and test set
       return Xtrain, Xtest, Ytrain, Ytest 
       for BORROW and REPAY classifier
    """
    
    # feature values
    x = data.iloc[:, 1:5].values
    
    # add constant 1 to get intercept in model
    x = np.column_stack((np.ones(x.shape[0]), x))

    # target values, last 2 columns of data frame
    y_borrow = data.iloc[:, 5].values
    y_repay = data.iloc[:, 6].values

    X_train1, X_test1, y_train1, y_test1 = train_test_split(x,
                                                            y_borrow,
                                                            test_size = 0.2, 
                                                            stratify = y_borrow, 
                                                            random_state = 0)

    X_train2, X_test2, y_train2, y_test2 = train_test_split(x, y_repay,
                                                            test_size = 0.2, 
                                                            stratify = y_repay, 
                                                            random_state = 0)
    return [(X_train1, X_test1, y_train1, y_test1),
            (X_train2, X_test2, y_train2, y_test2)]

def gradAscent(data, label, alpha, k): 
    """
       梯度上升求最优参数
    """
    X_matrix = np.mat(data)
    Y_matrix = np.mat(label).T

    m, n = X_matrix.shape

    # initialise weight matrix
    theta = np.mat(np.ones((n, 1)))

    for i in range(k):
        h = sigmoid(X_matrix * theta)
        error = Y_matrix - h
        theta += alpha * np.dot(X_matrix.transpose(), error)

    return theta

def stocGradAscent(data, label, alpha, k):  
    # 随机梯度上升，当数据量比较大时，每次迭代都选择全量数据进行计算，计算量会非常大。
    # 所以采用每次迭代中一次只选择其中的一行数据进行更新权重。
    X_matrix = np.mat(data)
    Y_matrix = label

    m, n = X_matrix.shape

    theta = np.ones((n, 1))

    for k in range(k):
        for i in range(m): #遍历计算每一行
            h = sigmoid(sum(X_matrix[i] * theta))
            error = Y_matrix[i] - h
            theta += alpha * X_matrix[i].transpose() * error  
    
    return theta

def stocGradAscent1(data, label, alpha, k): 
    # 改进版随机梯度上升，在每次迭代中随机选择样本来更新权重，
    # 并且随迭代次数增加，权重变化越小。
    X_matrix = np.mat(data)
    Y_matrix = label

    m, n = X_matrix.shape

    theta = np.ones((n, 1))

    for j in range(k): #迭代

        dataIndex = [i for i in range(m)]

        for i in range(m): #随机遍历每一行

            alpha = 4/(1+j+i) + 0.0001  #随迭代次数增加，权重变化越小。
            randIndex = int(np.random.uniform(0, len(dataIndex)))  #随机抽样
            h = sigmoid(sum(X_matrix[randIndex]*theta))
            error = Y_matrix[randIndex] - h
            theta += alpha * X_matrix[randIndex].transpose() * error
            np.delete(X_matrix, randIndex) #去除已经抽取的样本
    
    return theta


def logisticRegressionModel(data, label, method, alpha = 0.001, k = 500):
	"""
	   Update weights using SGD
	   alpha - gradient decline at each loop
	   k - number of loop
	   return optimised weights
	"""
	if method == "gradAscent":
		weights = gradAscent(data, label, alpha, k)

	elif method == "stocGradAscent":
		weights = stocGradAscent(data, label, alpha, k)

	else:
		weights = stocGradAscent1(data, label, alpha, k)

	return weights


def plotBestFit(weights):  #画出最终分类的图
    import matplotlib.pyplot as plt
    dataMat,labelMat=loadDataSet()
    dataArr = array(dataMat)
    n = shape(dataArr)[0]
    xcord1 = []; ycord1 = []
    xcord2 = []; ycord2 = []
    for i in range(n):
        if int(labelMat[i])== 1:
            xcord1.append(dataArr[i,1])
            ycord1.append(dataArr[i,2])
        else:
            xcord2.append(dataArr[i,1])
            ycord2.append(dataArr[i,2])
    fig = plt.figure()
    ax = fig.add_subplot(111)
    ax.scatter(xcord1, ycord1, s=30, c='red', marker='s')
    ax.scatter(xcord2, ycord2, s=30, c='green')
    x = arange(-3.0, 3.0, 0.1)
    y = (-weights[0]-weights[1]*x)/weights[2]
    ax.plot(x, y)
    plt.xlabel('X1')
    plt.ylabel('X2')
    plt.show()








