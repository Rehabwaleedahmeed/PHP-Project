# Team Branch Plan (4 Members)

## Main Branches
- main: release-ready only
- develop: integration branch

## Member Branches
- feature/rehab-api-security
- feature/nashat-routing-views
- feature/abdulrahman-orders-domain
- feature/kerora-frontend-stability

## Ownership
- Rehab: API security and user endpoints
- Nashat: route wiring and missing views/includes
- Abdulrahman: order model/controller consistency
- Kerora: JS/frontend stability and admin UI behavior

## Merge Flow
1. Branch from develop.
2. Push member branch to origin.
3. Open PR into develop.
4. Require 1 approval from a different member.
5. Merge without squash (use merge commit or rebase merge) to preserve each member's commits.
6. After all features pass checks, PR develop into main.

## Daily Sync
- Rebase or merge develop into your branch once per day.
- Resolve conflicts same day.
- Keep PRs small.

## Commit Ownership Protocol (Important)
- Each member must commit from their own machine/account.
- Each member commits only files in their assigned scope.
- Do not let one person commit on behalf of another member.
- Every PR should contain commits authored by the branch owner.

## Member-to-Branch Mapping
- Rehab -> feature/rehab-api-security
- Nashat -> feature/nashat-routing-views
- Abdulrahman -> feature/abdulrahman-orders-domain
- Kerora -> feature/kerora-frontend-stability

## One-Time Setup For Each Member
1. Clone repo and checkout your branch.
2. Configure your git identity (name/email linked to your GitHub account).
3. Pull latest changes before starting work.

```bash
git clone https://github.com/Rehabwaleedahmeed/PHP-Project.git
cd PHP-Project
git checkout feature/<your-branch>
git config user.name "<Your Name>"
git config user.email "<your-github-email>"
git pull origin feature/<your-branch>
```

## Commit Rules Per Member
1. Make changes only in your ownership area.
2. Commit in small chunks with clear messages.
3. Push to your own feature branch.
4. Open PR from your feature branch to develop.

```bash
git add <files>
git commit -m "feat(scope): short description"
git push origin feature/<your-branch>
```

## Pre-PR Checklist
- `git log --oneline --decorate -n 5` shows your own commits.
- `git status` is clean.
- Branch is up to date with `develop`.
- PR title references your scope.

## Current Repository Note
- Initial repository bootstrap commit is already on all branches.
- From this point onward, each member must add their own commits on their own branch.
