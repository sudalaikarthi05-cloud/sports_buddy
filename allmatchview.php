<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sports Matches Schedule — 50 Matches</title>
  <style>
    :root{
      --bg:#0f1724;
      --card:#0b1220;
      --muted:#9aa7b2;
      --accent1:#00d4ff;
      --accent2:#7c3aed;
      --glass: rgba(255,255,255,0.03);
      --row-even: rgba(255,255,255,0.02);
      --card-radius:14px;
      --table-radius:10px;
      --shadow: 0 8px 30px rgba(2,6,23,0.6);
    }

    html,body{
      height:100%;
      margin:0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#071025 0%, #08121b 60%);
      color:#e6eef6;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      padding:28px;
      box-sizing:border-box;
    }

    .wrap{
      max-width:1200px;
      margin:0 auto;
    }

    header {
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:16px;
      margin-bottom:18px;
    }

    .title {
      display:flex;
      gap:14px;
      align-items:center;
    }
    .logo {
      width:56px;
      height:56px;
      border-radius:12px;
      background:linear-gradient(135deg,var(--accent1),var(--accent2));
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:800;
      color:#041022;
      box-shadow: 0 6px 20px rgba(124,58,237,0.18);
    }
    h1 { font-size:20px; margin:0; }
    p.sub { margin:0; color:var(--muted); font-size:13px; }

    .card {
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:var(--card-radius);
      padding:14px;
      box-shadow:var(--shadow);
      border:1px solid rgba(255,255,255,0.03);
    }

    /* search / info row */
    .controls {
      display:flex;
      gap:10px;
      align-items:center;
      margin-bottom:12px;
      flex-wrap:wrap;
    }
    .controls .note { color:var(--muted); font-size:13px; }
    .controls .fake-search {
      margin-left:auto;
      display:flex;
      gap:8px;
      align-items:center;
    }
    .chip {
      background:var(--glass);
      padding:8px 12px;
      border-radius:999px;
      font-size:13px;
      color:var(--muted);
      border:1px solid rgba(255,255,255,0.02);
    }

    /* table */
    .table-wrap {
      overflow:auto;
      border-radius:var(--table-radius);
      border:1px solid rgba(255,255,255,0.03);
      margin-top:8px;
    }
    table {
      width:100%;
      border-collapse:collapse;
      min-width:980px;
      font-size:14px;
    }
    thead th {
      position:sticky;
      top:0;
      background:linear-gradient(180deg, rgba(12,18,28,0.9), rgba(8,12,18,0.85));
      color: #dff6ff;
      padding:14px 12px;
      text-align:left;
      font-weight:600;
      font-size:13px;
      letter-spacing:0.2px;
      border-bottom:1px solid rgba(255,255,255,0.04);
      z-index:2;
    }
    tbody td {
      padding:12px;
      border-bottom:1px dashed rgba(255,255,255,0.02);
      vertical-align:middle;
    }
    tbody tr:nth-child(even){ background: var(--row-even); }
    .sport-pill {
      display:inline-block;
      padding:6px 10px;
      border-radius:999px;
      font-weight:600;
      font-size:12px;
      color:#041022;
      background:linear-gradient(90deg,var(--accent1),var(--accent2));
      box-shadow: 0 4px 16px rgba(0,0,0,0.35);
    }
    .meta { color:var(--muted); font-size:13px; }
    .teams { font-weight:700; color:#f1fbff; }
    .venue { font-size:13px; color:var(--muted); }

    tbody tr:hover{
      transform:translateY(-3px);
      transition:transform .15s ease;
      background: linear-gradient(90deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));
    }

    /* small screens */
    @media (max-width:880px){
      :root{ --card-radius:12px; }
      table{ min-width:760px; }
    }

    /* responsive stacked cards for very small screens */
    @media (max-width:560px){
      .table-wrap { overflow:visible; }
      table { display:block; width:100%; }
      thead { display:none; }
      tbody tr {
        display:block;
        margin-bottom:10px;
        padding:12px;
        border-radius:10px;
        background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.01));
      }
      tbody td {
        display:flex;
        justify-content:space-between;
        padding:6px 10px;
        border-bottom:none;
      }
      tbody td.block { display:block; margin-top:8px; }
    }

    /* footer note */
    .foot-note { margin-top:12px; color:var(--muted); font-size:13px; }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="title">
        <div class="logo">SB</div>
        <div>
          <h1>Mixed Sports — 50 Matches Schedule</h1>
          <p class="sub">Cricket · Volleyball · Football · Basketball · Badminton · Tennis — Dates included</p>
        </div>
      </div>

      <div class="card" style="display:flex;align-items:center;gap:10px;">
        <div class="chip">Total: 50 matches</div>
        <div class="chip">From: 2025-08-10</div>
        <div class="chip">To: 2025-09-28</div>
      </div>
    </header>

    <div class="card">
      <div class="controls">
        <div class="note">Neat schedule table — hover a row for focus. Use this HTML as-is or plug into your site.</div>
        <div class="fake-search">
          <div class="chip">Filter: All sports</div>
          <div class="chip">Location: All</div>
        </div>
      </div>

      <div class="table-wrap">
        <table aria-label="50 match schedule">
          <thead>
            <tr>
              <th>#</th>
              <th>Sport</th>
              <th>Date</th>
              <th>Time</th>
              <th>Match (Home vs Away)</th>
              <th>Venue</th>
            </tr>
          </thead>
          <tbody>
            <!-- GENERATED 50 ROWS -->
            <tr><td>1</td><td><span class="sport-pill">Basketball</span></td><td>2025-08-10</td><td>16:45</td><td class="teams">Team 14 vs Team 22</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>2</td><td><span class="sport-pill">Basketball</span></td><td>2025-08-11</td><td>17:15</td><td class="teams">Team 10 vs Team 36</td><td class="venue">National Stadium</td></tr>
            <tr><td>3</td><td><span class="sport-pill">Badminton</span></td><td>2025-08-12</td><td>09:00</td><td class="teams">Team 1 vs Team 32</td><td class="venue">Riverside Ground</td></tr>
            <tr><td>4</td><td><span class="sport-pill">Badminton</span></td><td>2025-08-13</td><td>10:30</td><td class="teams">Team 9 vs Team 38</td><td class="venue">Central Park Field</td></tr>
            <tr><td>5</td><td><span class="sport-pill">Cricket</span></td><td>2025-08-14</td><td>16:00</td><td class="teams">Team 3 vs Team 31</td><td class="venue">East Court</td></tr>
            <tr><td>6</td><td><span class="sport-pill">Volleyball</span></td><td>2025-08-15</td><td>12:30</td><td class="teams">Team 12 vs Team 29</td><td class="venue">Community Ground</td></tr>
            <tr><td>7</td><td><span class="sport-pill">Tennis</span></td><td>2025-08-16</td><td>11:30</td><td class="teams">Team 17 vs Team 39</td><td class="venue">West Pavilion</td></tr>
            <tr><td>8</td><td><span class="sport-pill">Cricket</span></td><td>2025-08-17</td><td>14:45</td><td class="teams">Team 18 vs Team 25</td><td class="venue">Greenfield Stadium</td></tr>
            <tr><td>9</td><td><span class="sport-pill">Football</span></td><td>2025-08-18</td><td>19:00</td><td class="teams">Team 6 vs Team 24</td><td class="venue">Town Arena</td></tr>
            <tr><td>10</td><td><span class="sport-pill">Basketball</span></td><td>2025-08-19</td><td>18:15</td><td class="teams">Team 13 vs Team 34</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>11</td><td><span class="sport-pill">Tennis</span></td><td>2025-08-20</td><td>09:45</td><td class="teams">Team 11 vs Team 23</td><td class="venue">Central Park Field</td></tr>
            <tr><td>12</td><td><span class="sport-pill">Cricket</span></td><td>2025-08-21</td><td>15:00</td><td class="teams">Team 20 vs Team 26</td><td class="venue">City Sports Complex</td></tr>
            <tr><td>13</td><td><span class="sport-pill">Badminton</span></td><td>2025-08-22</td><td>10:00</td><td class="teams">Team 4 vs Team 27</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>14</td><td><span class="sport-pill">Volleyball</span></td><td>2025-08-23</td><td>13:30</td><td class="teams">Team 7 vs Team 30</td><td class="venue">National Stadium</td></tr>
            <tr><td>15</td><td><span class="sport-pill">Football</span></td><td>2025-08-24</td><td>20:15</td><td class="teams">Team 2 vs Team 28</td><td class="venue">Riverside Ground</td></tr>
            <tr><td>16</td><td><span class="sport-pill">Basketball</span></td><td>2025-08-25</td><td>17:00</td><td class="teams">Team 5 vs Team 35</td><td class="venue">Town Arena</td></tr>
            <tr><td>17</td><td><span class="sport-pill">Badminton</span></td><td>2025-08-26</td><td>09:30</td><td class="teams">Team 8 vs Team 21</td><td class="venue">Community Ground</td></tr>
            <tr><td>18</td><td><span class="sport-pill">Tennis</span></td><td>2025-08-27</td><td>11:00</td><td class="teams">Team 19 vs Team 37</td><td class="venue">West Pavilion</td></tr>
            <tr><td>19</td><td><span class="sport-pill">Cricket</span></td><td>2025-08-28</td><td>10:15</td><td class="teams">Team 15 vs Team 40</td><td class="venue">Greenfield Stadium</td></tr>
            <tr><td>20</td><td><span class="sport-pill">Volleyball</span></td><td>2025-08-29</td><td>14:00</td><td class="teams">Team 16 vs Team 33</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>21</td><td><span class="sport-pill">Football</span></td><td>2025-08-30</td><td>19:30</td><td class="teams">Team 14 vs Team 29</td><td class="venue">Town Arena</td></tr>
            <tr><td>22</td><td><span class="sport-pill">Badminton</span></td><td>2025-08-31</td><td>08:45</td><td class="teams">Team 6 vs Team 31</td><td class="venue">Central Park Field</td></tr>
            <tr><td>23</td><td><span class="sport-pill">Basketball</span></td><td>2025-09-01</td><td>18:00</td><td class="teams">Team 2 vs Team 20</td><td class="venue">National Stadium</td></tr>
            <tr><td>24</td><td><span class="sport-pill">Tennis</span></td><td>2025-09-02</td><td>10:30</td><td class="teams">Team 7 vs Team 24</td><td class="venue">West Pavilion</td></tr>
            <tr><td>25</td><td><span class="sport-pill">Cricket</span></td><td>2025-09-03</td><td>15:30</td><td class="teams">Team 9 vs Team 34</td><td class="venue">City Sports Complex</td></tr>
            <tr><td>26</td><td><span class="sport-pill">Volleyball</span></td><td>2025-09-04</td><td>12:15</td><td class="teams">Team 1 vs Team 36</td><td class="venue">Community Ground</td></tr>
            <tr><td>27</td><td><span class="sport-pill">Badminton</span></td><td>2025-09-05</td><td>09:00</td><td class="teams">Team 12 vs Team 28</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>28</td><td><span class="sport-pill">Basketball</span></td><td>2025-09-06</td><td>17:45</td><td class="teams">Team 19 vs Team 32</td><td class="venue">Town Arena</td></tr>
            <tr><td>29</td><td><span class="sport-pill">Football</span></td><td>2025-09-07</td><td>20:00</td><td class="teams">Team 8 vs Team 21</td><td class="venue">Riverside Ground</td></tr>
            <tr><td>30</td><td><span class="sport-pill">Tennis</span></td><td>2025-09-08</td><td>11:15</td><td class="teams">Team 4 vs Team 26</td><td class="venue">West Pavilion</td></tr>
            <tr><td>31</td><td><span class="sport-pill">Cricket</span></td><td>2025-09-09</td><td>16:00</td><td class="teams">Team 5 vs Team 35</td><td class="venue">Greenfield Stadium</td></tr>
            <tr><td>32</td><td><span class="sport-pill">Badminton</span></td><td>2025-09-10</td><td>09:30</td><td class="teams">Team 13 vs Team 23</td><td class="venue">Central Park Field</td></tr>
            <tr><td>33</td><td><span class="sport-pill">Volleyball</span></td><td>2025-09-11</td><td>13:45</td><td class="teams">Team 15 vs Team 37</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>34</td><td><span class="sport-pill">Basketball</span></td><td>2025-09-12</td><td>18:30</td><td class="teams">Team 3 vs Team 27</td><td class="venue">National Stadium</td></tr>
            <tr><td>35</td><td><span class="sport-pill">Tennis</span></td><td>2025-09-13</td><td>10:00</td><td class="teams">Team 16 vs Team 30</td><td class="venue">West Pavilion</td></tr>
            <tr><td>36</td><td><span class="sport-pill">Cricket</span></td><td>2025-09-14</td><td>14:30</td><td class="teams">Team 11 vs Team 25</td><td class="venue">City Sports Complex</td></tr>
            <tr><td>37</td><td><span class="sport-pill">Badminton</span></td><td>2025-09-15</td><td>08:00</td><td class="teams">Team 18 vs Team 33</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>38</td><td><span class="sport-pill">Football</span></td><td>2025-09-16</td><td>19:00</td><td class="teams">Team 17 vs Team 29</td><td class="venue">Town Arena</td></tr>
            <tr><td>39</td><td><span class="sport-pill">Volleyball</span></td><td>2025-09-17</td><td>13:00</td><td class="teams">Team 6 vs Team 22</td><td class="venue">Community Ground</td></tr>
            <tr><td>40</td><td><span class="sport-pill">Basketball</span></td><td>2025-09-18</td><td>17:30</td><td class="teams">Team 21 vs Team 38</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>41</td><td><span class="sport-pill">Cricket</span></td><td>2025-09-19</td><td>15:00</td><td class="teams">Team 2 vs Team 19</td><td class="venue">Greenfield Stadium</td></tr>
            <tr><td>42</td><td><span class="sport-pill">Tennis</span></td><td>2025-09-20</td><td>09:15</td><td class="teams">Team 12 vs Team 40</td><td class="venue">West Pavilion</td></tr>
            <tr><td>43</td><td><span class="sport-pill">Badminton</span></td><td>2025-09-21</td><td>10:00</td><td class="teams">Team 14 vs Team 36</td><td class="venue">Central Park Field</td></tr>
            <tr><td>44</td><td><span class="sport-pill">Football</span></td><td>2025-09-22</td><td>20:00</td><td class="teams">Team 9 vs Team 34</td><td class="venue">Riverside Ground</td></tr>
            <tr><td>45</td><td><span class="sport-pill">Volleyball</span></td><td>2025-09-23</td><td>12:00</td><td class="teams">Team 4 vs Team 28</td><td class="venue">Community Ground</td></tr>
            <tr><td>46</td><td><span class="sport-pill">Basketball</span></td><td>2025-09-24</td><td>18:45</td><td class="teams">Team 16 vs Team 39</td><td class="venue">National Stadium</td></tr>
            <tr><td>47</td><td><span class="sport-pill">Badminton</span></td><td>2025-09-25</td><td>08:30</td><td class="teams">Team 5 vs Team 26</td><td class="venue">Indoor Sports Hall</td></tr>
            <tr><td>48</td><td><span class="sport-pill">Tennis</span></td><td>2025-09-26</td><td>11:00</td><td class="teams">Team 3 vs Team 32</td><td class="venue">West Pavilion</td></tr>
            <tr><td>49</td><td><span class="sport-pill">Volleyball</span></td><td>2025-09-27</td><td>14:15</td><td class="teams">Team 8 vs Team 27</td><td class="venue">Town Arena</td></tr>
            <tr><td>50</td><td><span class="sport-pill">Cricket</span></td><td>2025-09-28</td><td>08:30</td><td class="teams">Team 16 vs Team 33</td><td class="venue">City Sports Complex</td></tr>
            <!-- /GENERATED -->
          </tbody>
        </table>
      </div>

      <div class="foot-note">Tip: want this CSV/JSON? I can export it. Want filtering (by sport/date) or an importable JSON for your app? I’ll provide code.</div>
    </div>

  </div>
</body>
</html>
