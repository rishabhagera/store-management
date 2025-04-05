<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login / Sign Up</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #f5f5f7;
    }
    .wrapper {
      display: flex;
      width: 850px;
      height: 500px;
      background: white;
      border-radius: 12px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .container {
      width: 50%;
      height: 100%;
      position: relative;
      transform-style: preserve-3d;
      transition: transform 0.6s ease-in-out;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background: white;
    }
    .flipped { transform: rotateY(180deg); }
    .card {
      width: 100%;
      max-width: 300px;
      position: absolute;
      backface-visibility: hidden;
      display: flex;
      flex-direction: column;
      text-align: center;
    }
    .sign-up { transform: rotateY(180deg); }
    h2 { font-size: 22px; margin-bottom: 20px; color: #333; }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #6c63ff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .toggle-container {
      margin-top: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .toggle-switch {
      position: relative;
      width: 50px;
      height: 24px;
    }
    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    .slider {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #ccc;
      border-radius: 24px;
      cursor: pointer;
    }
    .slider:before {
      content: "";
      position: absolute;
      width: 18px;
      height: 18px;
      left: 3px;
      bottom: 3px;
      background: white;
      border-radius: 50%;
      transition: 0.4s;
    }
    input:checked + .slider {
      background: #6c63ff;
    }
    input:checked + .slider:before {
      transform: translateX(26px);
    }
    .image-container {
      width: 50%;
      background: url('https://cdn.dribbble.com/userupload/16320784/file/original-fa8ba73df40eb8ff632329b53d976bd6.jpg?resize=1024x768&vertical=center') no-repeat center center/cover;
    }
  </style>
</head>
<body>

<div class="wrapper">
  <div class="container" id="flipContainer">
    <div class="card sign-in">
      <h2>Sign In</h2>
      <form method="POST" action="signin.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
      </form>
      <div class="toggle-container">
        <label class="toggle-switch">
          <input type="checkbox" id="toggleSwitch">
          <span class="slider"></span>
        </label>
        <p>Switch to Sign Up</p>
      </div>
    </div>

    <div class="card sign-up">
      <h2>Sign Up</h2>
      <form method="POST" action="signup.php">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
      </form>
      <div class="toggle-container">
        <label class="toggle-switch">
          <input type="checkbox" id="toggleSwitch2">
          <span class="slider"></span>
        </label>
        <p>Switch to Sign In</p>
      </div>
    </div>
  </div>
  <div class="image-container"></div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const flipContainer = document.getElementById("flipContainer");
    const toggleSwitch = document.getElementById("toggleSwitch");
    const toggleSwitch2 = document.getElementById("toggleSwitch2");

    toggleSwitch.addEventListener("change", () => {
      flipContainer.classList.toggle("flipped");
      toggleSwitch2.checked = toggleSwitch.checked;
    });
    toggleSwitch2.addEventListener("change", () => {
      flipContainer.classList.toggle("flipped");
      toggleSwitch.checked = toggleSwitch2.checked;
    });
  });
</script>

</body>
</html>
