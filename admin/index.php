<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sports Match Finder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --dark: #1e1e2d;
            --light: #f8f9fa;
            --sidebar-width: 250px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark) 0%, #2d3047 100%);
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: var(--success);
        }

        .sidebar-header p {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .sidebar-menu li.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--success);
        }

        .sidebar-menu li:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        /* Header Styles */
        .header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            font-size: 1.5rem;
            color: var(--dark);
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .user-info h4 {
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .user-info p {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: white;
        }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .bg-primary { background: var(--primary); }
        .bg-success { background: var(--success); }
        .bg-warning { background: var(--warning); }
        .bg-danger { background: var(--danger); }

        /* Section Headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 1.5rem;
            color: var(--dark);
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .matches-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .matches-table th {
            background: #f8f9fa;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            border-bottom: 1px solid #eee;
        }

        .matches-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .matches-table tr:last-child td {
            border-bottom: none;
        }

        .matches-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .status-upcoming {
            background: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        .status-completed {
            background: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn-view {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
        }

        .btn-delete {
            background: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }

        .btn-create {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
        }

        .btn-create:hover {
            background: var(--secondary);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s ease;
        }

        .modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            color: var(--dark);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
        }

        .btn-submit:hover {
            background: var(--secondary);
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #666;
        }

        .btn-cancel:hover {
            background: #e9ecef;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar-header h2, .sidebar-header p, .sidebar-menu span {
                display: none;
            }

            .sidebar-menu i {
                margin-right: 0;
                font-size: 1.2rem;
            }

            .main-content {
                margin-left: 70px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 15px;
            }

            .content {
                padding: 15px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .user-info {
                display: none;
            }
        }

        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .alert-success {
            background: rgba(76, 201, 240, 0.1);
            color: #155724;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: rgba(247, 37, 133, 0.1);
            color: #721c24;
            border-left: 4px solid var(--danger);
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>SportsMatch</h2>
            <p>Admin Dashboard</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="#">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Matches</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a href="view_matches.php">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Site</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Match Management</h1>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=4361ee&color=fff" alt="Admin User">
                    <div class="user-info">
                        <h4>Admin User</h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
<div class="content">
    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <h3 id="totalMatches">0</h3>
                <p>Total Matches</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 id="activeParticipants">0</h3>
                <p>Active Participants</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-basketball-ball"></i>
            </div>
            <div class="stat-info">
                <h3 id="sportsTypes">0</h3>
                <p>Sports Types</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="alert alert-success" id="successAlert" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <span id="alertMessage">Match created successfully!</span>
    </div>

    <!-- Section Header -->
    <div class="section-header">
        <h2>All Matches</h2>
        <!-- This button opens the modal -->
        <button class="btn btn-create" onclick="openModal()">
            <i class="fas fa-plus"></i> Create New Match
        </button>
    </div>

    <!-- Matches Table -->
    <div class="table-container">
        <table class="matches-table">
            <thead>
                <tr>
                    <th>Match Name</th>
                    <th>Sport Type</th>
                    <th>Location</th>
                    <th>Date & Time</th>
                    <th>Participants</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="matchesTableBody">
                <!-- Matches will be loaded here dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- Create Match Modal -->
<div class="modal" id="createMatchModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Create New Match</h3>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form id="matchForm">
            <div class="modal-body" style="padding: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="match_name" style="font-size: 0.9rem; margin-bottom: 5px;">Match Name</label>
                    <input type="text" id="match_name" name="match_name" class="form-control" placeholder="Enter match name" required style="padding: 10px; font-size: 0.9rem;">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="sport_type" style="font-size: 0.9rem; margin-bottom: 5px;">Sport Type</label>
                    <select id="sport_type" name="sport_type" class="form-control" required style="padding: 10px; font-size: 0.9rem;">
                        <option value="">Select Sport</option>
                        <option value="Football">Football</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Baseball">Baseball</option>
                        <option value="Hockey">Hockey</option>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="location" style="font-size: 0.9rem; margin-bottom: 5px;">Location</label>
                        <input type="text" id="location" name="location" class="form-control" placeholder="Location" required style="padding: 10px; font-size: 0.9rem;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="max_participants" style="font-size: 0.9rem; margin-bottom: 5px;">Max Players</label>
                        <input type="number" id="max_participants" name="max_participants" class="form-control" placeholder="Players" required style="padding: 10px; font-size: 0.9rem;">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="match_date" style="font-size: 0.9rem; margin-bottom: 5px;">Date & Time</label>
                    <input type="datetime-local" id="match_date" name="match_date" class="form-control" required style="padding: 10px; font-size: 0.9rem;">
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="needs" style="font-size: 0.9rem; margin-bottom: 5px;">Additional Needs (Optional)</label>
                    <textarea id="needs" name="needs" class="form-control" rows="2" placeholder="E.g., Bring your own equipment..." style="padding: 10px; font-size: 0.9rem; resize: vertical;"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="padding: 15px 20px;">
                <button type="button" class="btn btn-cancel" onclick="closeModal()" style="padding: 8px 15px; font-size: 0.85rem;">Cancel</button>
                <button type="submit" class="btn btn-submit" style="padding: 8px 15px; font-size: 0.85rem;">Create Match</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Load matches when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadMatches();
        loadStats();
        // Set minimum date to today
        const today = new Date().toISOString().slice(0, 16);
        document.getElementById('match_date').min = today;
    });

    // Modal Functions
    function openModal() {
        document.getElementById('createMatchModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('createMatchModal').style.display = 'none';
        document.getElementById('matchForm').reset();
    }

    // Load matches from database
    function loadMatches() {
        fetch('get_matches.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('matchesTableBody');
                tableBody.innerHTML = '';
                
                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No matches found</td></tr>';
                    return;
                }
                
                data.forEach(match => {
                    const row = document.createElement('tr');
                    const status = getMatchStatus(match.match_date);
                    const statusClass = getStatusClass(status);
                    
                    row.innerHTML = `
                        <td>${match.match_name}</td>
                        <td>${match.sport_type}</td>
                        <td>${match.location}</td>
                        <td>${formatDateTime(match.match_date)}</td>
                        <td>0/${match.max_participants}</td>
                        <td><span class="status-badge ${statusClass}">${status}</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-view" onclick="viewMatch(${match.id})"><i class="fas fa-eye"></i> View</button>
                                <button class="btn btn-delete" onclick="deleteMatch(${match.id})"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error loading matches:', error);
                showAlert('Error loading matches: ' + error.message, 'error');
            });
    }

    // Load statistics
    function loadStats() {
        fetch('get_stats.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('totalMatches').textContent = data.total_matches || 0;
                document.getElementById('activeParticipants').textContent = data.active_participants || 0;
                document.getElementById('sportsTypes').textContent = data.sports_types || 0;
            })
            .catch(error => {
                console.error('Error loading stats:', error);
                showAlert('Error loading statistics: ' + error.message, 'error');
            });
    }

    // Helper functions
    function getMatchStatus(matchDate) {
        const now = new Date();
        const matchDateTime = new Date(matchDate);
        
        if (matchDateTime < now) return 'Completed';
        if ((matchDateTime - now) < (24 * 60 * 60 * 1000)) return 'Active';
        return 'Upcoming';
    }

    function getStatusClass(status) {
        switch(status) {
            case 'Active': return 'status-active';
            case 'Upcoming': return 'status-upcoming';
            case 'Completed': return 'status-completed';
            default: return 'status-upcoming';
        }
    }

    function formatDateTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function viewMatch(matchId) {
        window.location.href = `view_match_details.php?id=${matchId}`;
    }

    function deleteMatch(matchId) {
        if (confirm('Are you sure you want to delete this match?')) {
            fetch(`delete_match.php?id=${matchId}`, { method: 'DELETE' })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Match deleted successfully!', 'success');
                        loadMatches();
                        loadStats();
                    } else {
                        showAlert('Error deleting match: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('Error deleting match: ' + error.message, 'error');
                    console.error('Error:', error);
                });
        }
    }

    function showAlert(message, type) {
        const alert = document.getElementById('successAlert');
        const alertMessage = document.getElementById('alertMessage');
        
        alertMessage.textContent = message;
        alert.className = `alert alert-${type}`;
        alert.style.display = 'flex';
        
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
                alert.style.opacity = '1';
            }, 500);
        }, 5000);
    }

    // Handle form submission
    document.getElementById('matchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form before submission
        if (!validateForm()) {
            return;
        }
        
        const formData = new FormData(this);
        
        // Show loading state
        const submitBtn = this.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        submitBtn.disabled = true;
        
        fetch('create_match.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    showAlert('Match added successfully!', 'success');
                    closeModal();
                    loadMatches();
                    loadStats();
                } else {
                    showAlert('Error adding match: ' + (data.message || 'Unknown error'), 'error');
                }
            } catch (e) {
                console.error('JSON parse error:', e);
                showAlert('Server error: Invalid response format', 'error');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showAlert('Network error: ' + error.message, 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Form validation function
    function validateForm() {
        const matchName = document.getElementById('match_name').value.trim();
        const sportType = document.getElementById('sport_type').value;
        const location = document.getElementById('location').value.trim();
        const matchDate = document.getElementById('match_date').value;
        const maxParticipants = document.getElementById('max_participants').value;
        
        if (!matchName) {
            showAlert('Please enter a match name', 'error');
            document.getElementById('match_name').focus();
            return false;
        }
        
        if (!sportType) {
            showAlert('Please select a sport type', 'error');
            document.getElementById('sport_type').focus();
            return false;
        }
        
        if (!location) {
            showAlert('Please enter a location', 'error');
            document.getElementById('location').focus();
            return false;
        }
        
        if (!matchDate) {
            showAlert('Please select a date and time', 'error');
            document.getElementById('match_date').focus();
            return false;
        }
        
        // Check if date is in the future
        const selectedDate = new Date(matchDate);
        const now = new Date();
        if (selectedDate <= now) {
            showAlert('Please select a future date and time', 'error');
            document.getElementById('match_date').focus();
            return false;
        }
        
        if (!maxParticipants || maxParticipants < 1) {
            showAlert('Please enter a valid number of participants', 'error');
            document.getElementById('max_participants').focus();
            return false;
        }
        
        return true;
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('createMatchModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
</body>
</html>