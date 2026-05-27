</div> <!-- Close content -->
</div> <!-- Close main -->

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

// Close sidebar when clicking on mobile menu item
document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            document.querySelector('.sidebar').classList.remove('active');
        }
    });
});

// Auto hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        setTimeout(() => {
            if (alert.parentNode) alert.remove();
        }, 300);
    });
}, 5000);

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            input.style.borderColor = '#ddd';
        }
    });
    if (!isValid) {
        alert('★ Tafadhali jaza sehemu zote zinazohitajika ★');
        return false;
    }
    return true;
}

// Confirmation for delete actions with Islamic message
document.querySelectorAll('.btn-danger').forEach(btn => {
    if (btn.getAttribute('onclick') === null) {
        btn.addEventListener('click', function(e) {
            if (!confirm('★ Tahadhari! Je, una hakika unataka kufanya hii? Hatua hii haiwezi kutenguliwa. ★')) {
                e.preventDefault();
            }
        });
    }
});

// Add twinkling stars effect dynamically
function createFloatingStar() {
    const star = document.createElement('div');
    star.innerHTML = '★';
    star.style.position = 'fixed';
    star.style.color = `rgba(255, 215, 0, ${Math.random() * 0.3})`;
    star.style.fontSize = `${Math.random() * 20 + 10}px`;
    star.style.left = `${Math.random() * 100}%`;
    star.style.top = `${Math.random() * 100}%`;
    star.style.pointerEvents = 'none';
    star.style.zIndex = '0';
    star.style.animation = 'starTwinkle 3s ease-in-out infinite';
    star.style.animationDelay = `${Math.random() * 3}s`;
    document.body.appendChild(star);
}

// Create multiple floating stars
for(let i = 0; i < 50; i++) {
    createFloatingStar();
}

// Add Bismillah on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('★ بسم الله الرحمن الرحيم ★');
});

// Animation for buttons on click
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (!this.disabled) {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        }
    });
});

// Add Islamic greeting based on time
function getIslamicGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return '☪ Subax wanaagsan!';
    if (hour < 18) return '☪ Maalin wanaagsan!';
    return '☪ Habeen wanaagsan!';
}

// Display greeting in console
console.log(getIslamicGreeting());
</script>
</body>
</html>