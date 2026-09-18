param(
    [string]$Target = "https://reinigingsdokter.nl",
    [string]$Skill = "seo-technical"
)

$repoPath = Join-Path $PSScriptRoot "..\codex-seo"
$runner = Join-Path $repoPath "scripts\run_skill_workflow.py"

if (-not (Test-Path $runner)) {
    throw "codex-seo is not available at $repoPath. Run 'npm run seo:install' first."
}

if (-not (Get-Command py -ErrorAction SilentlyContinue)) {
    throw "Python launcher 'py' was not found. Install Python 3.10+ first."
}

& py -3 $runner --skill $Skill $Target --json
