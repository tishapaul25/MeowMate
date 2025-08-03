<script>
document.addEventListener('DOMContentLoaded', () => {
  lucide.createIcons();

  // Mobile menu
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuIcon = document.getElementById('menu-icon');
  const closeIcon = document.getElementById('close-icon');

  mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
  });

  // Open Modals
  window.openModal = () => {
    const modal = document.getElementById("signupModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  };

  window.closeModal = () => {
    const modal = document.getElementById("signupModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
  };

  window.openSignInModal = () => {
    const modal = document.getElementById("signinModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  };

  window.closeSignInModal = () => {
    const modal = document.getElementById("signinModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
  };

  window.showResetForm = () => {
    document.getElementById("signinForm")?.classList.add("hidden");
    document.getElementById("resetForm")?.classList.remove("hidden");
  };

  window.showSignInForm = () => {
    document.getElementById("resetForm")?.classList.add("hidden");
    document.getElementById("signinForm")?.classList.remove("hidden");
  };

  // Hide modals on page load
  document.getElementById("signupModal")?.classList.add("hidden");
  document.getElementById("signinModal")?.classList.add("hidden");
});
</script>
