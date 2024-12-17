<?php
// Можно добавить здесь PHP код для обработки динамических данных, если необходимо
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | SDU UNIVERSITY</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;400;700;900&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="calendar.css" />
  </head>
  <body>
<!--  TOP BAR-->
      <div class="top-bar">
        <div class="left-section">
            <a href="page.html">
                <img src="logo_sdu_general.png" alt="Logo" class="logo-img">
            </a>
        </div>
       <ul class="nav" style="width: 20%; padding-left: 4%;">
          <li class="nav-item dropdown" style="margin-left: 10%;">
              <a class="nav-link" href="#" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o icon"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdown1">
                  <li><a class="dropdown-item" href="#">Notification 1</a></li>
                  <li><a class="dropdown-item" href="#">Notification 2</a></li>
                  <li><a class="dropdown-item" href="#">Notification 3</a></li>
              </ul>
          </li>
          <li class="nav-item dropdown" style="margin-left: -14%;">
              <a class="nav-link" href="#" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-comment-o icon"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdown2">
                  <li><a class="dropdown-item" href="#">Message 1</a></li>
                  <li><a class="dropdown-item" href="#">Message 2</a></li>
                  <li><a class="dropdown-item" href="#">Message 3</a></li>
              </ul>
          </li>
          <li class="nav-item dropdown" style="margin-left: -14%;">
              <a class="nav-link" href="#" id="dropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-user-o icon"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdown3">
                <li><a class="dropdown-item" href="C:\Users\User\Downloads\PM-main (1)\PM-main\profile\profile.html">My Profile</a></li>
                <li><a class="dropdown-item" href=" C:\Users\User\Downloads\PM-main (1)\PM-main\dashboard\page.html">My Dashboard</a></li>
                <li><a class="dropdown-item" href="C:\Users\User\Downloads\PM-main (1)\PM-main\login page\login.html">Log Out</a></li>
              </ul>
          </li>
       </ul>
      </div>
      <div style="padding-top: 10%; " >
      </div>


<!--MAIN PART-->




<h1>System Calendar</h1>
<table class="event-table">
           <thead>
               <tr>
                   <th>Event Title</th>
                   <th>Start Date</th>
                   <th>End Date</th>
                   <th>Status</th>
               </tr>
           </thead>
           <tbody>
               <tr>
                   <td>Course Registration (for students)</td>
                   <td>12.08.2024 00:00</td>
                   <td>23.08.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Add-Drop</td>
                   <td>09.09.2024 00:00</td>
                   <td>13.09.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Apply for Late Course Registration</td>
                   <td>16.09.2024 00:00</td>
                   <td>27.09.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Early withdrawal</td>
                   <td>30.09.2024 00:00</td>
                   <td>18.10.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Late withdrawal</td>
                   <td>21.10.2024 00:00</td>
                   <td>13.12.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Pre-final grade</td>
                   <td>25.11.2024 00:00</td>
                   <td>14.12.2024 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Final Exam</td>
                   <td>17.12.2024 00:00</td>
                   <td>04.01.2025 23:59</td>
                   <td class="opened">Opened</td>
               </tr>
               <tr>
                   <td>Apply for FX</td>
                   <td>04.01.2025 00:00</td>
                   <td>08.01.2025 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
               <tr>
                   <td>Resit Exam</td>
                   <td>11.01.2025 00:00</td>
                   <td>16.01.2025 23:59</td>
                   <td class="closed">Closed</td>
               </tr>
           </tbody>
       </table>
   </div>


<!--      FOOTER -->
      <div class="rectangle-14">
        <div class="line-15"></div>
        <div class="flex-container">
          <div class="flex-columns">
            <span class="titles">SDU UNIVERSITY</span>
            <a href="https://sdu.edu.kz/language/en/about-us-3/">
                <span class="nodes">About us</span>
            </a>
            <a href="https://sdukzlinks.tilda.ws/">
                <span class="nodes">Connect to us</span>
            </a>
          </div>

          <div class="flex-columns">
            <span class="titles">FACULTIES</span>
            <a href="https://sdu.edu.kz/language/en/business-school/">
                <span class="nodes">SDU BUSINESS SCHOOL</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/engineering-and-natural-sciences/">
                <span class="nodes">FACULTY OF ENGINEERING <br />AND NATURAL SCIENCES</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/education-and-humanities/">
                <span class="nodes">FACULTY OF EDUCATION <br />AND HUMANITIES</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/law-social-science/">
                <span class="nodes">FACULTY OF LAW AND <br />SOCIAL SCIENCES</span>
            </a>
          </div>

          <div class="flex-columns">
            <span class="titles">RULES</span>
            <a href="https://sdu.edu.kz/language/en/rules/">
                <span class="nodes">Charter</span>
            </a>
            <a href="https://sdu.edu.kz/language/en/rules/">
                <span class="nodes">Safety rules</span>
            </a>
          </div>

          <div class="flex-columns">
            <span class="titles">ADDRESS</span>
            <span class="nodes">Almaty region, Karasai district.</span>
            <span class="nodes">040900, city of Kaskelen, st. <br />Abylai Khan 1/1</span>
          </div>
        </div>
        <div class="line-17"></div>
        <div class="flex-row-daab">
          <div>
            <i class="material-icons" >language</i>
            <span class="nodes">SDU UNIVERSITY</span>
          </div>
          <div>
             <i class="material-icons" >phone</i>
             <span class="nodes">Mobile: + 7 727 307 9565</span>
          </div>
          <div>
            <i class="material-icons" >mail_outline</i>
            <span class="nodes">cdl@sdu.edu.kz</span>
          </div>
        </div>
        <span class="copyright-reserved">Copyright © All right reserved SDU University</span>
      </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

