const themeLink = document.getElementById('theme-style');
const toggleBtn = document.getElementById('theme-toggle');



function setTheme(theme) {
    themeLink.href = theme === 'dark'
        ? '/public/assets/css/dark.css'
        : '/public/assets/css/style.css';
    localStorage.setItem('theme', theme);
}

toggleBtn?.addEventListener('click', () => {
    const current = localStorage.getItem('theme') || 'light';
    setTheme(current === 'light' ? 'dark' : 'light');
    alert(current);
});

window.addEventListener('load', () => {
    const saved = localStorage.getItem('theme') || 'light';
    setTheme(saved);
});
