# 🚀 Forsa-Liya — AI-Powered Developer Learning Platform

> Replace traditional education with AI-guided, practice-based learning. Build real projects. Get evaluated. Level up.

---

## 📋 Project Overview

**Forsa-Liya** (Arabic for "My Opportunity") is an MVP web application that helps developers learn software development by completing AI-generated real-world projects. The system generates unique projects based on your level and track, evaluates you through a quiz after submission, and adapts difficulty dynamically.

---

## ✅ Features

| Feature | Status |
|---------|--------|
| Register / Login / Logout (Breeze) | ✅ Working |
| Track & Branch Selection (Frontend / Backend / Fullstack) | ✅ Working |
| AI Project Generation (Gemini / fallback) | ✅ Working |
| Project Submission (GitHub URL + notes) | ✅ Working |
| AI Quiz Generation (4 questions per project) | ✅ Working |
| Quiz Scoring (60% pass threshold) | ✅ Working |
| AI Action Plan (on failure) | ✅ Working |
| Progress Dashboard (XP, level, stats) | ✅ Working |
| Skill Validation tracking | ✅ Working |
| Adaptive Difficulty (level up after 3/10 passes) | ✅ Working |
| Branch Switching (profile page) | ✅ Working |
| Dark Mode UI with Tailwind + custom CSS | ✅ Working |
| Static fallback when AI API unavailable | ✅ Working |

---

## 🧱 Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 13 |
| Frontend | Blade + Tailwind CSS + Vite |
| Database | MySQL 8+ |
| AI | Google Gemini 1.5 Flash (primary) |
| Auth | Laravel Breeze (Blade stack) |
| HTTP Client | Guzzle 7 |
| PHP | 8.3+ |

---

## 📦 Installation

### Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+ & npm
- MySQL 8+ (Laragon recommended on Windows)
- Laragon or similar local dev environment

### Step 1 — Clone / Navigate to Project
```bash
cd c:\laragon\www\Forsa-Liya
```

### Step 2 — Install Dependencies
```bash
composer install
npm install
```

### Step 3 — Configure Environment
```bash
copy .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forsa_liya
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=your_gemini_api_key_here
```

### Step 4 — Create Database
```bash
mysql -u root -e "CREATE DATABASE forsa_liya CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 5 — Run Migrations & Seed
```bash
php artisan migrate
php artisan db:seed
```

### Step 6 — Build Assets
```bash
npm run build
```

### Step 7 — Start the Server
```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## 🤖 AI Setup

The app uses **Google Gemini 1.5 Flash** for generating projects, quizzes, and action plans.

### Get a Free Gemini API Key
1. Go to [Google AI Studio](https://aistudio.google.com/)
2. Sign in with your Google account
3. Click **Get API key** → Create API key
4. Copy the key and add it to `.env`:
   ```env
   GEMINI_API_KEY=AIzaSy...your_key_here
   ```

### Fallback Mode
If no API key is set or the API call fails, the system automatically uses **static fallback data** with pre-written project templates and quiz questions. The app is fully functional without an API key for testing purposes.

---

## 🗄️ Database Schema

```
users               — id, name, email, level, current_track_id, current_branch_id, xp_points, projects_completed, projects_passed
tracks              — id, name, slug, description, icon, color
branches            — id, track_id, name, slug, description, order, icon
projects            — id, user_id, branch_id, title, description, requirements, constraints, expected_features, difficulty, deadline, status
submissions         — id, project_id, user_id, github_url, notes, submitted_at
quiz_questions      — id, project_id, question, type, options, correct_answer, explanation, order
results             — id, project_id, user_id, submission_id, quiz_score, quiz_answers, passed, action_plan, evaluated_at
skills_progress     — id, user_id, branch_id, projects_completed, projects_passed, is_validated
```

---

## 🎮 How to Use

1. **Register** an account at `/register`
2. **Choose a Track** (Frontend / Backend / Fullstack) and a branch skill
3. **Generate a Project** from the Dashboard — the AI creates a real-world brief
4. **Build the project** on your local machine or GitHub Codespaces
5. **Submit** your GitHub repository link
6. **Take the Quiz** — 4 AI-generated questions about your own project
7. **Pass (60%+)** → earn XP, skill validated, difficulty increases
8. **Fail** → receive a personalized action plan to improve

---

## ⚠️ Limitations (MVP)

- No actual code review — evaluation is quiz-based only
- No real-time code analysis or GitHub API integration
- AI quiz questions are conceptual, not automated test runners
- No email verification flow (disabled for MVP simplicity)
- No payment/subscription system
- No admin panel for managing content
- Branch switching resets your branch but doesn't affect your score history

---

## 🔮 Future Improvements

- [ ] GitHub API integration to count commits and analyze code
- [ ] Video/audio quizzes with AI proctoring
- [ ] Team projects & peer review system
- [ ] Admin dashboard for track/branch management
- [ ] Leaderboard & community features
- [ ] Mobile app (React Native)
- [ ] Stripe subscription for premium content
- [ ] AI code review with detailed feedback
- [ ] Certificate generation for validated skills
- [ ] Discord bot for notifications

---

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── TrackController.php
│   ├── ProjectController.php
│   ├── SubmissionController.php
│   ├── QuizController.php
│   ├── ResultController.php
│   └── ProfileController.php
├── Models/
│   ├── User.php
│   ├── Track.php
│   ├── Branch.php
│   ├── Project.php
│   ├── Submission.php
│   ├── QuizQuestion.php
│   ├── Result.php
│   └── SkillProgress.php
└── Services/
    └── AIService.php           ← Gemini integration + fallbacks
database/
├── migrations/                 ← 8 custom migrations
└── seeders/
    └── TrackSeeder.php         ← 3 tracks, 16 branches
resources/views/
├── layouts/
│   ├── app.blade.php           ← Sidebar layout
│   └── guest.blade.php         ← Auth layout
├── dashboard/index.blade.php
├── tracks/index.blade.php
├── projects/show.blade.php
├── quiz/show.blade.php
├── results/show.blade.php
└── profile/show.blade.php
```

---

## 🛠️ Development

```bash
# Run dev server with hot reload
npm run dev

# In another terminal
php artisan serve

# Clear all caches
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Re-seed database
php artisan migrate:fresh --seed
```

---

## 📄 License

MIT — Built as an educational MVP project.

---

*Built with ❤️ using Laravel 13, Tailwind CSS, and Google Gemini AI*
