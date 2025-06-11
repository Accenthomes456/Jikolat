<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company = htmlspecialchars($_POST['company']);
    $title = htmlspecialchars($_POST['title']);
    $location = htmlspecialchars($_POST['location']);
    $type = htmlspecialchars($_POST['type']);
    $description = nl2br(htmlspecialchars($_POST['description']));
    $apply_link = htmlspecialchars($_POST['apply_link']);

    $job = <<<EOD
<div class="bg-white p-4 rounded shadow mb-4 animate-fadeIn">
  <h3 class="text-xl font-bold text-blue-800">{$title}</h3>
  <p class="text-sm text-gray-500">{$company} • {$location} • {$type}</p>
  <p class="mt-2 text-gray-700">{$description}</p>
  <a href="{$apply_link}" class="inline-block mt-3 text-blue-600 font-semibold hover:underline" target="_blank">Apply Now</a>
</div>

EOD;

    file_put_contents("jobs.txt", $job, FILE_APPEND);
    header("Location: post-job.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post a Job</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(to right, #00c6ff, #0072ff);
      animation: gradient 10s ease infinite;
    }
    @keyframes gradient {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .animate-fadeIn {
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="text-gray-800 min-h-screen flex flex-col items-center py-10 px-4">

  <div class="w-full max-w-3xl bg-white p-8 rounded-xl shadow-xl animate-fadeIn">
    <h1 class="text-3xl font-bold text-blue-900 text-center mb-6">Post a Job</h1>

    <?php if (isset($_GET['success'])): ?>
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">Job posted successfully!</div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="company" placeholder="Company Name" required class="w-full p-2 border border-gray-300 rounded" />
      <input type="text" name="title" placeholder="Job Title" required class="w-full p-2 border border-gray-300 rounded" />
      <input type="text" name="location" placeholder="Location" required class="w-full p-2 border border-gray-300 rounded" />
      <select name="type" required class="w-full p-2 border border-gray-300 rounded">
        <option value="Full-Time">Full-Time</option>
        <option value="Part-Time">Part-Time</option>
        <option value="Contract">Contract</option>
        <option value="Internship">Internship</option>
      </select>
      <textarea name="description" rows="5" placeholder="Job Description" required class="w-full p-2 border border-gray-300 rounded"></textarea>
      <input type="text" name="apply_link" placeholder="Application Link or Email" required class="w-full p-2 border border-gray-300 rounded" />
      <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 w-full">Submit Job</button>
    </form>
  </div>

  <div class="w-full max-w-3xl mt-10">
    <h2 class="text-2xl text-white font-semibold mb-4">Recent Jobs</h2>
    <?php
      if (file_exists("jobs.txt")) {
        echo file_get_contents("jobs.txt");
      } else {
        echo "<p class='text-white'>No jobs posted yet.</p>";
      }
    ?>
  </div>

</body>
</html>
