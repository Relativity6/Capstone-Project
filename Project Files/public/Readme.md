The public folder will hold all files/pages that can be accessed by users of the application.

---------------Page Summaries--------------------

Page: register.php  
Summary: Users may register a LuminHealth account on this page.  
Screenshot:  
![SS07 - Register](https://user-images.githubusercontent.com/40231621/192077821-f902936d-7762-4fce-a165-09b01bb7c984.jpg)  
  
Page: login.php  
Summary: Users may login to their account on this page.  
Screenshot:  
![SS06 - Login](https://user-images.githubusercontent.com/40231621/192077828-0b825829-332e-4814-9996-3bc180293863.jpg)  

Page: Dashboard.php  
Summary: Main navigation hub of the site. CDC Twitter feed.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS12 - Dashboard](https://user-images.githubusercontent.com/40231621/196006927-161f1a8d-bb0c-460e-a258-fd7d207d80bd.jpg)  

Page: profile.php  
Summary: Users may see their profile information on this page. If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS08 - Profile](https://user-images.githubusercontent.com/40231621/196006968-806b08c8-4a75-460f-a4b8-f100f2de1783.jpg)  

Page: edit-profile.php  
Summary: Users may edit their profile information on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS09 - Update profile](https://user-images.githubusercontent.com/40231621/196007012-6f2118cb-41dc-42ba-baf4-8fa6f181b8cf.jpg)  

Page: update-picture.php  
Summary: Users may edit their profile picture on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS10 - Update picture](https://user-images.githubusercontent.com/40231621/192077897-afc17127-eaf5-4aa5-9612-950638c7012a.jpg)  

Page: delete-member.php  
Summary: Users may delete their LuminHealth account on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS11 - Delete profile](https://user-images.githubusercontent.com/40231621/192077903-f529bf71-9548-4d22-818e-bb3bb28ecdf1.jpg)  

Page: group.php  
Required in query string: group_id  
Summary: This page provides group details for the group whose ID is in the query string. If the user is not a member, it provides a password input field to join. If the user is a member, it displays group details and a link to leave-group.php.  If the user is the admin of the group, it displays group details and links to edit-group.php and delete-group.php.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshots:  
![SS14 - Group page nonmember](https://user-images.githubusercontent.com/40231621/192077845-c66b481b-acec-4b85-b572-9c7e5bcb11eb.jpg)  
![SS13 - Group page Admin](https://user-images.githubusercontent.com/40231621/192077854-828ce7ab-c167-463f-bdc7-1042aed4ce93.jpg)  
![SS13 - Group page Member](https://user-images.githubusercontent.com/40231621/192077861-77a26ebf-8acf-401e-a489-c1f5978438e8.jpg)  

Page: edit-group.php  
Required in query string: group_id  
Summary: Admins can remove other members of the group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user who is not the admin attempts to view this page, they are redirected to page-not-found.php.  
Screenshot:  
![SS18 - Edit Group](https://user-images.githubusercontent.com/40231621/192077961-966b8edf-f097-4119-a033-e4d1f702f891.jpg)  

Page: group-search.php  
Summary: Users can search for groups to join on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS16 - Group Search](https://user-images.githubusercontent.com/40231621/192077984-d6fb0bde-1cde-4cba-ac6a-b1ad196493b1.jpg)  

Page: new-group.php  
Summary: Users can create new groups on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  
Screenshot:  
![SS17 - Create Group](https://user-images.githubusercontent.com/40231621/192078007-c40ad4b8-9432-4e7d-bbed-edc47f9af9d8.jpg)  

Page: delete-group.php  
Required in query string: group_id  
Summary: Admins can delete their group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user who is not the admin attempts to view this page, they are redirected to page-not-found.php.  
Screenshot: 
![SS19 - Delete Group](https://user-images.githubusercontent.com/40231621/192078040-3c6e2c2f-2156-4be8-ac66-4be8bdc3b7c3.jpg)  

Page: leave-group.php  
Required in query string: group_id  
Summary: Users can leave their group on this page.  If a user attempts to view this page without being logged in, they are redirected to login.php.  If a user attempts to view this page and they are not a member, they are redirected to group.php.  
Screenshot:  
![SS15 - Leave group](https://user-images.githubusercontent.com/40231621/192078087-2f633d9d-7498-407e-8f29-056cdff5138e.jpg)  
