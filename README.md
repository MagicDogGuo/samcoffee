# Demo website
https://samkuo.click/samcafe/index.php

![cafe Screenshot](samcafe/assets/A.png) 
![cafe Screenshot](samcafe/assets/B.png) 
![cafe Screenshot](samcafe/assets/C.png) 
![cafe Screenshot](samcafe/assets/D.png) 

# AWS Architecture
![My coffee Website](https://github.com/user-attachments/assets/dc13ec58-de7c-4b87-885a-1844e5b859fc)

# VPC

VPC Resource map

![image](https://github.com/user-attachments/assets/5efe827b-89db-444c-986d-ccb644919f4f)

The infrastructure includes **4 subnets**:

- **2 Public Subnets**: These are accessible from the internet
- **2 Private Subnets**: These are isolated from direct internet access and are generally used for databases.

![image](https://github.com/user-attachments/assets/6e4222fa-e55f-48cd-95e9-8954ffc7637a)


**Network ACLs (NACLs):**

- **Name:** `coffee-ACL`
- **Assigned to:** Public Subnets
- **Rules:** Allow **all inbound and outbound traffic**

![image](https://github.com/user-attachments/assets/84b4d905-b9be-4ac5-8c33-b2f8cbe6744d)


- **Name:** `DB-ACL`
- **Assigned to:** Private Subnets
- **Rules:** Private subnets only allow MySQL/Aurora traffic over port 3306 

![image](https://github.com/user-attachments/assets/631ff55f-c238-4b9e-a02e-8559e248d9e1)

**Security Group**

- Database Security Group 

- allow traffic from CoffeeSG(MyBlog-SG)

![image](https://github.com/user-attachments/assets/be07c630-b300-4257-b4f4-1d44a12f5cc8)

- Coffee Security Group(MyBlog-SG)

- allow traffic from Public Network (HTTP, HTTPs, MySQL, SSH)

![image](https://github.com/user-attachments/assets/0132051b-0202-4ab6-ac44-22579bbad05a)

# EC2

Have two EC2 in us-west-1a and us-west-1c

![image](https://github.com/user-attachments/assets/cf42c773-9130-4a91-967a-389e6f768fe2)


# Auto Scaling Group

**Desired Capacity** : `2`

**Scaling Limits** : `2 - 4`

![image](https://github.com/user-attachments/assets/f9125d31-e15a-4873-a24a-4b9e78a59428)

# Applicant Load Balancer

Resource map

ALB provides traffic distribution functionality at the HTTP and HTTPS layers, while ASG can automatically adjust the number of instances to respond to traffic fluctuations.

![image](https://github.com/user-attachments/assets/95b4cc19-fde6-4637-89a5-798529461780)

# RDS

Configure Multi-AZ Deployment with RDS Subnet Group

The subnets of the database subnet group include two subnets, **us-west-1a** and **us-west-1c**, which are located in different availability zones.

![image](https://github.com/user-attachments/assets/ae2f7abb-408f-422d-bfaa-24d3c28e85ce)

The database uses MariaDB.

The instance is deployed in the **us-west-1** region, specifically in the `1a` availability zone.

Publicly Accessible: `No`

![image](https://github.com/user-attachments/assets/e0a31a94-ebc7-4686-baae-1458bb327ae0)


# Route 53

Alias feature enabled, this record will point to CloudFront.

Using Smaple Route

![image](https://github.com/user-attachments/assets/89725e87-8e3f-4df3-8c24-f3c0b7d8b8f1)

# Cloudfront

The CloudFront distribution will use all available edge locations 
A custom domain name, `samkuo.click`, has been associated with the distribution.

A custom SSL certificate created with Certificate Manager is being used to ensure secure HTTPS connections.

![image](https://github.com/user-attachments/assets/b6932abd-81cb-4a5a-a0de-c876122a343b)

