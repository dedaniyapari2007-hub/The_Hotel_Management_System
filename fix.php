<?php
$c = file_get_contents('c:\new_xampp\htdocs\Projet\style.css');
$c = preg_replace('/\.navbar \{.*\.nav-links a:hover::after \{/s', '.navbar {
  background: rgba(245, 235, 224, 0.85);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  border-bottom: 1px solid rgba(255, 255, 255, 0.3);
  position: sticky;
  top: 0;
  z-index: 1000;
  width: 100%;
  transition: all 0.3s ease;
}

.nav-container {
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  align-items: center;
  padding: 12px 40px;
  max-width: 1600px;
  margin: 0 auto;
  gap: 30px;
}

.logo-area {
  display: flex;
  align-items: center;
  text-decoration: none;
  gap: 12px;
  transition: transform 0.3s ease;
  justify-self: start;
}

.logo-area:hover {
  transform: scale(1.02);
}

.logo-text {
  font-family: \'Cinzel\', serif;
  color: #1f2937;
  font-size: 30px;
  letter-spacing: 3px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.logo-img {
  height: 50px;
  width: auto;
  filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.1));
}

.nav-links {
  display: flex;
  list-style: none;
  gap: 35px;
  align-items: center;
  justify-self: center;
}

.nav-links a {
  color: #1f2937;
  text-decoration: none;
  font-size: 16px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  position: relative;
  padding: 5px 0;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: \'\';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #D4A373;
  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #D4A373;
}

.nav-links a:hover::after {', $c);
file_put_contents('c:\new_xampp\htdocs\Projet\style.css', $c);
