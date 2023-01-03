# Requirements

For following scenario of a redemption campaign:
- Support multiple languages
- Register by mobile with password
- Earn random points by daily lucky draw (once a day)
- List e-coupon with details including quota and required points, which could update via CMS
- Redeem e-coupon by points
- Each redemption will have an unique QR code

1. Test 1: Draw an ERD
2. Test 2: Design APIs with sample request and responses (in Postman or document format is fine)

# General
- This is a test project, so I just focus on main things (code logic with only main cases, table-columns are important ones) 
- I tried to add more things (Unit test, Functional Test, CI/CD, Swagger, Service/Repository...) to this project instead of going deep
### EER Diagram
![EER image](https://user-images.githubusercontent.com/11681514/210364965-db3f7322-91fd-48ef-bab4-bbcd4f212c0f.png)
- We have **coupon_categories** table, User can redeem **coupon_category** to create many **coupons**
- **coupons** will have two types
1. used one time (type=1). It can be created by redemption
2. used many times (type=2). It is common code (e.g NEWYEAR2023) for anyone can use.
  ![image](https://user-images.githubusercontent.com/11681514/210383403-5bd191cb-bcfa-408f-bc7d-e266eafeff56.png)
### API documents
- **[Postman collection](https://github.com/mbvb1223/coupon/blob/master/public/Khien%20Coupon.postman_collection.json)**
- Swagger UI (added some APIs for demo - not all of APIs): http://localhost:8000/api/documentation
![EER image](https://user-images.githubusercontent.com/11681514/210369700-7c5550e1-6cbe-42c2-996e-a1942eebd955.png)

  

### Exported Database
- **[URL here](https://github.com/mbvb1223/coupon/blob/master/public/coupon_dump20230103.sql)**

### CI
![Circleci](https://user-images.githubusercontent.com/11681514/210367623-23355959-0f3d-4e09-a362-e7304e71b145.png)
- **[Circleci](https://app.circleci.com/pipelines/github/mbvb1223/coupon)**

### Demo Video 
ssss

# More detail
- [x] Support multiple languages
- Please allow me not to finish coding this feature. Because it will take time to support multiple languages in Database and Code layer.
- I will explain some main ways we can do 
1. Easiest: Coupon(id, name_en, name_vn, price): Add a column for each column of text that needs translation (it is quick but will get big problem when the application grows in functions/more languages)
2. Medium: Coupon(id, price) + CouponTranslation(coupon_id, language_id, name): Store translated texts into another table. (The drawback for this options is creating more tables but it will support well for multi-language feature)
3. Hardest: Entity–attribute–value model (EAV) https://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model. Magento is using this pattern to support for multi-language. (Not only support well for multi-language but it also support for adding flexible attribues. Database will come much too complicated)
- **For all options above, we can create an infrastructure code layer to support get/save with multi-language.**

- [x] Register by mobile with password
1. Create a new user with name+email+password
2. Use Sanctum: https://laravel.com/docs/9.x/sanctum to generate a new token
![Image](https://user-images.githubusercontent.com/11681514/210374702-e66b0dee-f6c4-4ead-b745-c9759fbf5596.png)
3. Wrote **Function Testing** to cover 100% User APIs => https://github.com/mbvb1223/coupon/blob/master/tests/Feature/UserTest.php. We can check online result here https://app.circleci.com/pipelines/github/mbvb1223/coupon/13/workflows/25abfe92-148a-44f3-9053-79e74f2e4327/jobs/13/parallel-runs/0/steps/0-109
![Image](https://user-images.githubusercontent.com/11681514/210371973-b247c5dd-1e56-4ba7-a503-6073d9083602.png)

- [x] Earn random points by daily lucky draw (once a day)
1. We can config maximum number of draws per day at "constant.point.max_lucky_draw_per_day"
2. As you see code here: https://github.com/mbvb1223/coupon/blob/master/app/Http/Controllers/API/PointController.php I tried to apply S (SOLID) to "luckyDraw" method. Each function has a separate responsibility. Actually, for a real project with more logic, we can split validation logic, and point algorithm logic to another service/class..
![Image](https://user-images.githubusercontent.com/11681514/210374507-4c519e64-a0cf-4a0b-b02b-6b832f626181.png)

- [x] List e-coupon with details including quota and required points, which could update via CMS
1. Actually, I understand that this is E-coupon category (not E coupon). From an E-coupon category we can generate many E-coupons
![Image](https://user-images.githubusercontent.com/11681514/210375070-a5f73415-ec11-467d-889f-b98944b35ce0.png)

- [x] Redeem e-coupon by points
1. For this feature, we have more logic, so I used Service/Repository pattern to implement this. Service will handle for business logic and will be covered by Unit Tests. Repo will handle to get Data from Database.
2. Wroted **Unit tests** to cover 100% RedemptionService here: https://github.com/mbvb1223/coupon/blob/master/tests/Unit/RedemptionServiceTest.php
![Image](https://user-images.githubusercontent.com/11681514/210376023-f32f5aa1-9b3f-4a98-884b-ce4a45bc6483.png)

- [x] Each redemption will have an unique QR code
1. I used this package to generate QR code: simplesoftwareio/simple-qrcode
2. QR code will be encoded (base64_encode), FE will decode and show it to end user.
![Image](https://user-images.githubusercontent.com/11681514/210376677-b0612180-42b6-4587-9182-faa06726ccf9.png)
