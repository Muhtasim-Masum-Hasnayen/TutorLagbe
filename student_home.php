<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TutorLagbe - Student Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Poppins', sans-serif;
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      background: linear-gradient(to right, #edf2fb, #d7e3fc);
      color: #333;
      min-height: 100vh;
    }

    header {
      background: #081c15;
      color: #fff;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    header img {
      height: 45px;
    }

    .welcome {
      font-size: 18px;
      font-weight: 500;
    }

    .logout-btn {
      background: #e63946;
      border: none;
      padding: 10px 16px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: #b01e2d;
    }

    .container {
      padding: 40px;
    }

    .dashboard-title {
      font-size: 28px;
      margin-bottom: 20px;
      color: #081c15;
      font-weight: 600;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: #fff;
      padding: 20px;
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transition: 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
    }

    .card i {
      font-size: 36px;
      margin-bottom: 10px;
      color: #0077b6;
    }

    .card h3 {
      font-size: 20px;
      margin-bottom: 8px;
      color: #081c15;
    }

    .card p {
      font-size: 14px;
      color: #333;
    }

    footer {
      text-align: center;
      margin-top: 50px;
      padding: 20px;
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>

<header>
  <div class="header-left">
    <button id="sidebarToggle" aria-label="Toggle Sidebar">
      <i class="fas fa-bars"></i>
    </button>
    <img src="TutorLagbe.png" alt="TutorLagbe Logo" class="logo">
  </div>
  <div class="welcome">👋 Welcome, <?php echo htmlspecialchars($name); ?></div>
  <a href="logout.php"><button class="logout-btn">Logout</button></a>
</header>

<div class="wrapper">
  <nav id="sidebar">
    <ul>
      <li><a href="Student_find_tutor.php"><i class="fas fa-search"></i><span>Find Tutors</span></a></li>
      <li><a href="student_post.php"><i class="fas fa-book-open"></i><span>Post </span></a></li>
      <li><a href="Student_messages.php"><i class="fas fa-comments"></i><span>Messages</span></a></li>
      <li><a href="Student_Profile.php"><i class="fas fa-user"></i><span>My Profile</span></a></li>
    </ul>
  </nav>

  <main class="content">
    <h1 class="dashboard-title">🎓 Student Dashboard</h1>
    <div class="cards">
      <div class="card">
        <i class="fas fa-search"></i>
        <h3>Find Tutors</h3>
        <p>Search and connect with expert tutors by subject and location.</p>
      </div>

      <div class="card">
        <i class="fas fa-book-open"></i>
        <h3>My Courses</h3>
        <p>View and manage all your enrolled tutoring sessions and progress.</p>
      </div>

      <div class="card">
        <i class="fas fa-comments"></i>
        <h3>Messages</h3>
        <p>Chat with tutors directly and get real-time support.</p>
      </div>

      <div class="card">
        <i class="fas fa-user"></i>
        <h3>My Profile</h3>
        <p>Update your personal info, password, and preferences.</p>
      </div>
    </div>
  </main>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> TutorLagbe. All rights reserved.
</footer>

<!-- Scripts -->
<script>
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
  });
</script>

<style>
  /* Reset & base */
  * {
    font-family: 'Poppins', sans-serif;
    margin: 0; padding: 0; box-sizing: border-box;
  }
  body {
    background: linear-gradient(to right, #edf2fb, #d7e3fc);
    color: #333;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* Header */
  header {
    background: #081c15;
    color: #fff;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }
  .header-left {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  #sidebarToggle {
    font-size: 20px;
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: color 0.3s ease;
  }
  #sidebarToggle:hover {
    color: #0077b6;
  }
  header .logo {
    height: 45px;
  }
  .welcome {
    font-size: 18px;
    font-weight: 500;
  }
  .logout-btn {
    background: #e63946;
    border: none;
    padding: 10px 16px;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
  }
  .logout-btn:hover {
    background: #b01e2d;
  }

  /* Wrapper flex for sidebar + content */
  .wrapper {
    flex: 1;
    display: flex;
    min-height: calc(100vh - 88px); /* header + footer height approx */
  }

  /* Sidebar */
  #sidebar {
    background: #081c15;
    color: #fff;
    width: 250px;
    transition: width 0.3s ease;
    overflow: hidden;
  }
  #sidebar.collapsed {
    width: 70px;
  }
  #sidebar ul {
    list-style: none;
    padding: 20px 0;
  }
  #sidebar ul li {
    margin-bottom: 10px;
  }
  #sidebar ul li a {
    color: #fff;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 25px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease;
    white-space: nowrap;
  }
  #sidebar ul li a:hover {
    background: #0077b6;
    border-radius: 6px;
  }
  #sidebar ul li a i {
    font-size: 20px;
    min-width: 20px;
    text-align: center;
  }
  #sidebar.collapsed ul li a span {
    display: none;
  }

  /* Main content */
  main.content {
    flex: 1;
    padding: 40px;
    overflow-y: auto;
  }

  /* Dashboard title */
  .dashboard-title {
    font-size: 28px;
    margin-bottom: 30px;
    color: #081c15;
    font-weight: 600;
  }

  /* Cards grid */
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap: 20px;
  }
  .card {
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transition: 0.3s ease;
    cursor: default;
  }
  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.12);
  }
  .card i {
    font-size: 36px;
    margin-bottom: 10px;
    color: #0077b6;
  }
  .card h3 {
    font-size: 20px;
    margin-bottom: 8px;
    color: #081c15;
  }
  .card p {
    font-size: 14px;
    color: #333;
  }

  /* Footer */
  footer {
    text-align: center;
    padding: 20px;
    font-size: 14px;
    color: #666;
    background: #f8f8f8;
  }

  /* Responsive for smaller devices */
  @media (max-width: 768px) {
    #sidebar {
      position: fixed;
      height: 100%;
      z-index: 1000;
      left: -250px;
      top: 0;
      transition: left 0.3s ease;
    }
    #sidebar.active {
      left: 0;
    }
    #sidebar.collapsed {
      width: 250px;
    }
    .wrapper {
      flex-direction: column;
    }
    main.content {
      padding: 20px;
    }
    #sidebarToggle {
      font-size: 24px;
    }
  }
</style>

<script>
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');

  toggleBtn.addEventListener('click', () => {
    // For desktop toggle collapse
    if(window.innerWidth > 768){
      sidebar.classList.toggle('collapsed');
    } else {
      // For mobile toggle show/hide sidebar
      sidebar.classList.toggle('active');
    }
  });

  // Close sidebar on link click in mobile mode
  document.querySelectorAll('#sidebar ul li a').forEach(link => {
    link.addEventListener('click', () => {
      if(window.innerWidth <= 768){
        sidebar.classList.remove('active');
      }
    });
  });
</script>

</body>

</html>
