demo website: https://samkuo.click/samcafe/index.php

AWS Architecture
![My coffee Website](https://github.com/user-attachments/assets/dc13ec58-de7c-4b87-885a-1844e5b859fc)

# VPC

VPC Resource map

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/2e9ab0c3-4bc3-4055-afb1-31eb5c7e5216/%E5%9C%96%E7%89%87.png)

The infrastructure includes **4 subnets**:

- **2 Public Subnets**: These are accessible from the internet
- **2 Private Subnets**: These are isolated from direct internet access and are generally used for databases.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/c5606e54-2620-49ce-a2aa-99868f091578/%E5%9C%96%E7%89%87.png)

**Network ACLs (NACLs):**

- **Name:** `coffee-ACL`
- **Assigned to:** Public Subnets
- **Rules:** Allow **all inbound and outbound traffic**

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/f003af41-5e94-403f-95a4-beb8e28ad9f8/%E5%9C%96%E7%89%87.png)

Name: DB-ACL
Assigned to: Private Subnets

Private subnets only allow MySQL/Aurora traffic over port 3306 

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/192e2a5e-6d56-429a-b7a3-47987e350226/%E5%9C%96%E7%89%87.png)

Database Security Group 

allow traffic from CoffeeSG(MyBlog-SG)

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/36930dd7-3b6b-4c28-94a4-4ae3d11ed63a/%E5%9C%96%E7%89%87.png)

Coffee Security Group(MyBlog-SG)

allow traffic from Public Network (HTTP, HTTPs, MySQL, SSH)

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/f4f72ff9-5939-48e5-8778-d92296a1ecda/%E5%9C%96%E7%89%87.png)

# EC2

Have two EC2 in us-west-1a and us-west-1c

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/87ff9a4d-adb6-4b81-83bb-a56acb6ecb9b/%E5%9C%96%E7%89%87.png)

The infrastructure includes **4 subnets**:

- **2 Public Subnets**: These are accessible from the internet
- **2 Private Subnets**: These are isolated from direct internet access and are generally used for databases.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/c5606e54-2620-49ce-a2aa-99868f091578/%E5%9C%96%E7%89%87.png)

**Network ACLs (NACLs):**

- **Name:** `coffee-ACL`
- **Assigned to:** Public Subnets
- **Rules:** Allow **all inbound and outbound traffic**

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/f003af41-5e94-403f-95a4-beb8e28ad9f8/%E5%9C%96%E7%89%87.png)

Name: DB-ACL
Assigned to: Private Subnets

Private subnets only allow MySQL/Aurora traffic over port 3306 

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/192e2a5e-6d56-429a-b7a3-47987e350226/%E5%9C%96%E7%89%87.png)

Database Security Group 

allow traffic from CoffeeSG(MyBlog-SG)

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/36930dd7-3b6b-4c28-94a4-4ae3d11ed63a/%E5%9C%96%E7%89%87.png)

Coffee Security Group(MyBlog-SG)

allow traffic from Public Network (HTTP, HTTPs, MySQL, SSH)

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/f4f72ff9-5939-48e5-8778-d92296a1ecda/%E5%9C%96%E7%89%87.png)

# EC2

Have two EC2 in us-west-1a and us-west-1c

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/87ff9a4d-adb6-4b81-83bb-a56acb6ecb9b/%E5%9C%96%E7%89%87.png)

# Auto Scaling Group

**Desired Capacity** : `2`

**Scaling Limits** : `2 - 4`

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/acc7bbcb-dfc8-4430-ab7c-d62a6a89b44d/%E5%9C%96%E7%89%87.png)

# Applicant Load Balancer

Resource map

ALB provides traffic distribution functionality at the HTTP and HTTPS layers, while ASG can automatically adjust the number of instances to respond to traffic fluctuations.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/ac69955d-e52b-4d60-a6a2-469733f29501/%E5%9C%96%E7%89%87.png)

# RDS

Configure Multi-AZ Deployment with RDS Subnet Group

The subnets of the database subnet group include two subnets, **us-west-1a** and **us-west-1c**, which are located in different availability zones.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/dd1eb909-f691-4d41-ac12-0e4e78b080f8/%E5%9C%96%E7%89%87.png)

The database uses MariaDB.

The instance is deployed in the **us-west-1** region, specifically in the `1a` availability zone.

**Publicly Accessible**: `No`
# Auto Scaling Group

**Desired Capacity** : `2`

**Scaling Limits** : `2 - 4`

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/acc7bbcb-dfc8-4430-ab7c-d62a6a89b44d/%E5%9C%96%E7%89%87.png)

# Applicant Load Balancer

Resource map

ALB provides traffic distribution functionality at the HTTP and HTTPS layers, while ASG can automatically adjust the number of instances to respond to traffic fluctuations.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/ac69955d-e52b-4d60-a6a2-469733f29501/%E5%9C%96%E7%89%87.png)

# RDS

Configure Multi-AZ Deployment with RDS Subnet Group

The subnets of the database subnet group include two subnets, **us-west-1a** and **us-west-1c**, which are located in different availability zones.

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/dd1eb909-f691-4d41-ac12-0e4e78b080f8/%E5%9C%96%E7%89%87.png)

The database uses MariaDB.

The instance is deployed in the **us-west-1** region, specifically in the `1a` availability zone.

**Publicly Accessible**: `No`

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/bd7f4cd9-ef2d-4675-b5d6-0de75e2ac041/%E5%9C%96%E7%89%87.png)

# Route 53

Alias feature enabled, this record will point to CloudFront.

Using Smaple Route

![圖片.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/1d7410be-1d90-4f64-86d0-3620dfee456e/d03ed99e-01ff-4b20-b9d8-0e5fb7e70ac7/%E5%9C%96%E7%89%87.png)

# Cloudfront

The CloudFront distribution will use all available edge locations 
A custom domain name, `samkuo.click`, has been associated with the distribution.

A custom SSL certificate created with Certificate Manager is being used to ensure secure HTTPS connections.
