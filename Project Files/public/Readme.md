The public folder will hold all files/pages that can be accessed by users of the application.

## Page Summaries
### Page List
- [Register page](https://github.com/Relativity6/Capstone-Project/tree/main/Project%20Files/public#page-registerphp)
- Login page
- Dashboard page
- Profile page
- Edit Profile page
- Update Profile Picture page
- Delete Profile page
- Group page
- Edit Group page
- Group Search page
- New Group page
- Delete Group page
- Leave Group page
- Alert page

### Page: register.php  
**Summary**: Users may register a LuminHealth account on this page.  
**Screenshot**:  
![SS07 - Register](https://user-images.githubusercontent.com/40231621/192077821-f902936d-7762-4fce-a165-09b01bb7c984.jpg)  
  
### Page: login.php  
**Summary**: Users may login to their account on this page.  
**Screenshot**:  
![SS06 - Login](https://user-images.githubusercontent.com/40231621/192077828-0b825829-332e-4814-9996-3bc180293863.jpg)  

### Page: Dashboard.php  
**Summary**: Main navigation hub of the site. CDC Twitter feed.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS12 - Dashboard](https://user-images.githubusercontent.com/40231621/196006927-161f1a8d-bb0c-460e-a258-fd7d207d80bd.jpg)  

### Page: profile.php  
**Summary**: Users may see their profile information on this page. If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS08 - Profile](https://user-images.githubusercontent.com/40231621/196006968-806b08c8-4a75-460f-a4b8-f100f2de1783.jpg)  

### Page: edit-profile.php  
**Summary**: Users may edit their profile information on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  

### Page: update-picture.php  
**Summary**: Users may edit their profile picture on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS10 - Update picture](https://user-images.githubusercontent.com/40231621/196007053-4dd3b404-08ff-4d44-b1b3-df7ebcb8a4fb.jpg)  

### Page: delete-member.php  
**Summary**: Users may delete their LuminHealth account on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS11 - Delete profile](https://user-images.githubusercontent.com/40231621/196007111-7086a7ed-4ac8-4d1e-8394-0606b98703e7.jpg)  

### Page: group.php  
**Summary**: This page provides group details for the group whose ID is in the query string. If the user is not a member, it provides a password input field to join. If the user is a member, it displays group details and a link to leave-group.php.  If the user is the admin of the group, it displays group details and links to edit-group.php and delete-group.php.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS14 - Group page nonmember](https://user-images.githubusercontent.com/40231621/196007301-99016e34-3b15-4cfb-abca-7fac3c0d1062.jpg)  
![SS13 - Group page Admin](https://user-images.githubusercontent.com/40231621/196007313-7b5297a3-87eb-4673-a44f-d3e6046ff916.jpg)  
![SS13 - Group page Member](https://user-images.githubusercontent.com/40231621/196007321-280958b2-39e9-4a84-be77-0ea3b76e229a.jpg)  

### Page: edit-group.php  
**Summary**: Admins can remove other members of the group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user who is not the admin attempts to view this page, they are redirected to page-not-found.php.  
**Screenshot**:  
![SS18 - Edit Group](https://user-images.githubusercontent.com/40231621/196009895-e6174e8a-fd79-4c02-b82f-b5fb5b899b1d.jpg)  

### Page: group-search.php  
**Summary**: Users can search for groups to join on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS16 - Group Search](https://user-images.githubusercontent.com/40231621/192077984-d6fb0bde-1cde-4cba-ac6a-b1ad196493b1.jpg)  

### Page: new-group.php  
**Summary**: Users can create new groups on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
**Screenshot**:  
![SS17 - Create Group](https://user-images.githubusercontent.com/40231621/192078007-c40ad4b8-9432-4e7d-bbed-edc47f9af9d8.jpg)  

### Page: delete-group.php  
**Summary**: Admins can delete their group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user who is not the admin attempts to view this page, they are redirected to page-not-found.php.  
**Screenshot**: 
![SS19 - Delete Group](https://user-images.githubusercontent.com/40231621/196009930-d3e2ea40-f816-4435-9f70-e7534b68fd73.jpg)  

### Page: leave-group.php  
**Summary**: Users can leave their group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user attempts to view this page and they are not a member, they are redirected to group.php.  
**Screenshot**:  
![SS15 - Leave group](https://user-images.githubusercontent.com/40231621/196009959-a9ee2d85-586e-4b99-ae1e-fe72a27f5886.jpg)  

### Page: alert.php  
**Summary**: If users click the Alert button displayed on the page, all members that the user is associated with in his/her groups will be notified via email and SMS. The page then redirects back to dashboard.php. A "cancel" button is also provided which redirects to dashboard.php.  
**Screenshot**:  
![SS25 - Alert page](https://user-images.githubusercontent.com/40231621/196010069-3f1120de-0b9c-429c-906e-4e6a388fa75b.jpg)  
