<?php
include("db_config.php");

// Fetch distinct districts for dropdown
$districts = [];
$district_query = mysqli_query($conn, "SELECT DISTINCT district FROM tutors WHERE status='approved' ORDER BY district ASC");
while ($drow = mysqli_fetch_assoc($district_query)) {
  $districts[] = $drow['district'];
}

// Handle filter
$selected_district = isset($_GET['district']) ? $_GET['district'] : '';
$sql = "
  SELECT t.*, u.name
  FROM tutors t
  JOIN users u ON t.user_id = u.id
  WHERE u.role = 'tutor' AND t.status = 'approved'
";
if (!empty($selected_district)) {
  $safe_district = mysqli_real_escape_string($conn, $selected_district);
  $sql .= " AND t.district = '$safe_district'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Find Tutor | TutorLagbe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a2e0f1f432.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background: #f4f7fa; color: #333; }

    .topbar {
      background: #1d3557;
      color: white;
      padding: 10px 50px;
      text-align: right;
      font-size: 14px;
    }

    .navbar {
      background: white;
      display: flex;
      justify-content: space-between;
      padding: 20px 50px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 24px;
      font-weight: 600;
      color: #1d3557;
    }

    .navbar .logo img {
      height: 40px;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    .navbar ul li a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: 0.3s;
    }

    .navbar ul li a:hover,
    .navbar ul li a.active {
      color: #1d3557;
      font-weight: 700;
    }

    .hero {
      padding: 80px 50px 40px 50px;
      background: linear-gradient(to right, #f1f8ff, #e4f3ff);
      text-align: center;
    }

    .hero h1 {
      font-size: 40px;
      color: #1d3557;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
    }

    .section {
      padding: 50px;
      background: white;
      max-width: 1200px;
      margin: auto;
      border-radius: 12px;
      box-shadow: 0 0 30px rgb(0 0 0 / 0.07);
    }

    .section h2 {
      text-align: center;
      font-size: 36px;
      color: #1d3557;
      margin-bottom: 40px;
    }

    .filter-form {
      text-align: center;
      margin-bottom: 30px;
    }

    .filter-form select, .filter-form button {
      padding: 10px 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin: 0 10px;
      font-size: 16px;
    }

    .filter-form button {
      background-color: #1d3557;
      color: white;
      border: none;
      cursor: pointer;
    }

    .tutor-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
    }

    .tutor-card {
      background: #f9fbff;
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .tutor-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .tutor-photo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 4px solid #1d3557;
    }

    .tutor-name {
      font-size: 22px;
      color: #1d3557;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .tutor-subject {
      font-size: 16px;
      color: #457b9d;
      margin-bottom: 5px;
    }

    .tutor-district {
      font-size: 14px;
      color: #555;
    }

    .no-tutors {
      text-align: center;
      font-size: 18px;
      color: #c0392b;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      text-align: center;
      color: #1d3557;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
      animation: zoomIn 0.3s ease;
    }

    .modal-content h2 {
      margin-bottom: 10px;
    }

    .modal-content p {
      margin: 6px 0;
      font-size: 16px;
    }

    .modal-content .btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #1d3557;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .modal-content .btn:hover {
      background-color: #457b9d;
    }

    @keyframes zoomIn {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    footer {
      background: #0b132b;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 60px;
      user-select: none;
    }
  </style>
</head>
<body>

  <div class="topbar">
    📞 Helpline: +880-1234-567890 | ✉ info@tutorlagbe.com
  </div>

  <div class="navbar">
    <div class="logo">
      <img src="TutorLagbe.png" alt="TutorLagbe Logo"> TutorLagbe
    </div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="how_it_works.php">How it Works</a></li>
      <li><a class="active" href="Student_find_tutor.php">Find Tutor</a></li>
      <li><a href="#" id="postTuitionBtn">Post Tuition</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </div>

  <div class="hero">
    <h1>Find Trusted Tutors</h1>
    <p>Filter by district or browse all approved tutors.</p>
  </div>

  <div class="section">
    <form method="get" class="filter-form">
      <select name="district">
        <option value="">-- Filter by District --</option>
        <?php foreach ($districts as $d): ?>
          <option value="<?= htmlspecialchars($d) ?>" <?= $d == $selected_district ? 'selected' : '' ?>>
            <?= htmlspecialchars($d) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Search</button>
    </form>

    <div class="tutor-grid">
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <?php
            $photo = trim($row['profile_photo']);
            $filepath = (!empty($photo) && file_exists("uploads/$photo")) ? "uploads/$photo" : "uploads/default-profile.png";
          ?>
          <div class="tutor-card"
            data-name="<?= htmlspecialchars($row['name']) ?>"
            data-district="<?= htmlspecialchars($row['district']) ?>"
            data-subject="<?= htmlspecialchars($row['subject_specialty']) ?>"
            data-qualification="<?= htmlspecialchars($row['qualification']) ?>"
            data-experience="<?= htmlspecialchars($row['experience']) ?>"
            data-photo="<?= htmlspecialchars($filepath) ?>"
          >
            <img src="<?= htmlspecialchars($filepath) ?>" class="tutor-photo" alt="Tutor Photo" />
            <div class="tutor-name"><?= htmlspecialchars($row['name']) ?></div>
            <div class="tutor-subject"><?= htmlspecialchars($row['subject_specialty']) ?></div>
            <div class="tutor-district">📍 <?= htmlspecialchars($row['district']) ?></div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="no-tutors">No tutors found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Modal -->
  <div id="tutorModal" class="modal">
    <div class="modal-content">
      <h2 id="modalName"></h2>
      <img id="modalPhoto" src="" alt="Tutor Photo" style="width:100px; height:100px; border-radius:50%; margin:10px auto; border: 3px solid #1d3557;" />
      <p id="modalDistrict"></p>
      <p id="modalSubject"></p>
      <p id="modalQualification"></p>
      <p id="modalExperience"></p>
      <button class="btn cancel-btn" onclick="document.getElementById('tutorModal').style.display='none'">Close</button>
    </div>
  </div>

  <footer>
    &copy; <?= date("Y") ?> TutorLagbe. All rights reserved.
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script> AOS.init(); </script>
  <script>
    const cards = document.querySelectorAll('.tutor-card');
    cards.forEach(card => {
      card.addEventListener('click', () => {
        document.getElementById('modalName').innerText = card.dataset.name;
        document.getElementById('modalPhoto').src = card.dataset.photo;
        document.getElementById('modalDistrict').innerText = 'District: ' + card.dataset.district;
        document.getElementById('modalSubject').innerText = 'Subject: ' + card.dataset.subject;
        document.getElementById('modalQualification').innerText = 'Qualification: ' + card.dataset.qualification;
        document.getElementById('modalExperience').innerText = 'Experience: ' + card.dataset.experience;
        document.getElementById('tutorModal').style.display = 'flex';
      });
    });

    window.onclick = function(event) {
      const modal = document.getElementById('tutorModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>
</html>
