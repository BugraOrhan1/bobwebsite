# Codex SEO integration for this website

This project now includes the local Codex SEO toolkit in the workspace folder `codex-seo` and a small wrapper script to run SEO audits directly against the website.

## Quick start

1. Install the SEO toolkit:
   ```powershell
   npm run seo:install
   ```

2. Audit the live production site:
   ```powershell
   npm run seo:audit
   ```

3. Audit the local development site:
   ```powershell
   npm run seo:local
   ```

4. Run a technical SEO audit specifically:
   ```powershell
   npm run seo:technical
   ```

## What is included

- `codex-seo/` — cloned SEO skill suite from GitHub
- `scripts/seo-audit.ps1` — wrapper that calls the workflow runner with the current site URL
- `package.json` — convenience scripts for the site team

## Notes

- Production target defaults to `https://reinigingsdokter.nl`.
- Local target defaults to `http://localhost:3000` for the PHP dev server.
- The underlying audit is powered by the Codex SEO toolkit and writes output inside the runtime directories created by that project.
