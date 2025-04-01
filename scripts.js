
// scripts.js

document.addEventListener("DOMContentLoaded", function () {
  // --- Hamburger Menu & Mobile Contacts ---

  // Create hamburger menu button
  const menuToggle = document.createElement("button");
  menuToggle.classList.add("menu-toggle");
  menuToggle.setAttribute("aria-label", "Toggle navigation menu");
  menuToggle.innerHTML =
    '<span class="bar"></span><span class="bar"></span><span class="bar"></span>';

  // Get the nav element and insert the button before the logo
  const nav = document.querySelector("nav");
  if (nav) {
    nav.insertBefore(menuToggle, nav.firstChild);
  }

  // Create mobile contacts div
  const mobileContacts = document.createElement("div");
  mobileContacts.className = "mobile-owner-contacts"; // Initially hidden by CSS
  mobileContacts.innerHTML = `
        <p>Jacob: <a href="tel:3473596247">(347) 359-6247</a></p>
        <p>Solomon: <a href="tel:9176541699">(917) 654-1699</a></p>
    `;

  // Add mobile contacts div after the header
  const header = document.querySelector("header");
  if (header && header.parentNode) {
    header.parentNode.insertBefore(mobileContacts, header.nextSibling);
  }

  // Toggle menu and mobile contacts on click
  const navMenu = document.querySelector("nav ul");

  if (menuToggle && navMenu && mobileContacts) {
    menuToggle.addEventListener("click", function () {
      navMenu.classList.toggle("show");
      mobileContacts.classList.toggle("show"); // Use class to toggle visibility
      menuToggle.classList.toggle("active");
      document.body.classList.toggle("menu-open"); // Toggle body class for scroll lock
    });
  }

  // Close menu when clicking outside or on a link
  function closeMenu() {
    if (navMenu && mobileContacts && menuToggle) {
      if (navMenu.classList.contains("show")) {
        navMenu.classList.remove("show");
        mobileContacts.classList.remove("show");
        menuToggle.classList.remove("active");
        document.body.classList.remove("menu-open");
      }
    }
  }

  // Close menu when clicking outside
  document.addEventListener("click", function (event) {
    if (navMenu && menuToggle) {
      // Check if the click is outside the nav menu and the toggle button
      if (
        !navMenu.contains(event.target) &&
        !menuToggle.contains(event.target) &&
        navMenu.classList.contains("show")
      ) {
        closeMenu();
      }
    }
  });

  // --- Smooth Scrolling for Navigation Links ---
  document
    .querySelectorAll('nav a[href^="#"], .cta-button[href^="#"]')
    .forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");
        // Ensure it's an internal link
        if (href.startsWith("#")) {
          e.preventDefault();
          closeMenu(); // Close mobile menu if open

          const targetId = href;
          const targetElement = document.querySelector(targetId);

          if (targetElement) {
            const headerOffset =
              document.querySelector("header")?.offsetHeight || 0;
            const elementPosition =
              targetElement.getBoundingClientRect().top + window.pageYOffset;
            // Adjust offset slightly more if needed
            const offsetPosition = elementPosition - headerOffset - 20;

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

  // --- Set current year in footer ---
  const yearElement = document.getElementById("year");
  if (yearElement) {
    yearElement.textContent = new Date().getFullYear();
  }
});
