// Create and add hamburger menu button
document.addEventListener("DOMContentLoaded", function () {
  // Create hamburger menu button
  const menuToggle = document.createElement("button");
  menuToggle.classList.add("menu-toggle");
  menuToggle.setAttribute("aria-label", "Toggle navigation menu");
  menuToggle.innerHTML =
    '<span class="bar"></span><span class="bar"></span><span class="bar"></span>';

  // Get the nav element and insert the button
  const nav = document.querySelector("nav");
  nav.insertBefore(menuToggle, nav.firstChild);

  // Create mobile contacts div
  const mobileContacts = document.createElement("div");
  mobileContacts.className = "mobile-owner-contacts";
  mobileContacts.innerHTML = `
                <p>Jacob: <a href="tel:3473596247">(347) 359-6247</a></p>
                <p>Solomon: <a href="tel:9176541699">(917) 654-1699</a></p>
            `;
  mobileContacts.style.display = "none";

  // Add to body
  document.body.appendChild(mobileContacts);

  // Toggle menu on click
  menuToggle.addEventListener("click", function () {
    const navMenu = document.querySelector("nav ul");
    navMenu.classList.toggle("show");

    // Toggle mobile contacts visibility based on menu state
    if (navMenu.classList.contains("show")) {
      mobileContacts.classList.add("show"); // Use class to control display
    } else {
      mobileContacts.classList.remove("show");
    }

    menuToggle.classList.toggle("active");
    document.body.classList.toggle("menu-open"); // Optional: for potential body styling when menu is open
  });

  // Close menu when clicking outside (Improved logic)
  document.addEventListener("click", function (event) {
    const navMenu = document.querySelector("nav ul");
    const menuButton = document.querySelector(".menu-toggle");
    const mobileContactsDiv = document.querySelector(".mobile-owner-contacts"); // Renamed for clarity

    // Check if the menu is shown and the click was outside the nav menu AND outside the toggle button
    if (
      navMenu.classList.contains("show") &&
      !navMenu.contains(event.target) && // Click is not inside the menu list
      !menuButton.contains(event.target) // Click is not the menu button itself
    ) {
      navMenu.classList.remove("show");
      mobileContactsDiv.classList.remove("show");
      menuButton.classList.remove("active");
      document.body.classList.remove("menu-open");
    }
  });

  // Smooth Scrolling for Navigation Links
  document
    .querySelectorAll('nav a[href^="#"], .cta-button[href^="#"]')
    .forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        if (this.getAttribute("href").startsWith("#")) {
          e.preventDefault();

          // Close mobile menu if open
          const navMenu = document.querySelector("nav ul");
          const menuButton = document.querySelector(".menu-toggle");
          const mobileContactsDiv = document.querySelector(
            ".mobile-owner-contacts"
          ); // Renamed

          if (navMenu.classList.contains("show")) {
            navMenu.classList.remove("show");
            mobileContactsDiv.classList.remove("show");
            menuButton.classList.remove("active");
            document.body.classList.remove("menu-open");
          }

          const targetId = this.getAttribute("href");
          const targetElement = document.querySelector(targetId);

          if (targetElement) {
            const headerOffset =
              document.querySelector("header")?.offsetHeight || 0;
            const elementPosition =
              targetElement.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - headerOffset - 20; // Added buffer

            window.scrollTo({
              top: offsetPosition,
              behavior: "smooth",
            });
          } else if (targetId === "#hero") {
            // Special case for scrolling to top
            window.scrollTo({
              top: 0,
              behavior: "smooth",
            });
          }
        }
      });
    });

  // Set current year in footer
  const yearElement = document.getElementById("year");
  if (yearElement) {
    yearElement.textContent = new Date().getFullYear();
  }
});
