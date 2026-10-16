[CmdletBinding()]
param()

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ProjectRoot = Split-Path -Parent $PSScriptRoot
$FailureCount = 0

Write-Host ""
Write-Host "==============================================" -ForegroundColor Cyan
Write-Host " KIEM TRA PHAN II - THIET KE DT-16" -ForegroundColor Cyan
Write-Host "==============================================" -ForegroundColor Cyan
Write-Host "Thu muc du an: $ProjectRoot"
Write-Host ""

function Write-Result {
    param(
        [Parameter(Mandatory = $true)]
        [bool] $Passed,

        [Parameter(Mandatory = $true)]
        [string] $Label
    )

    if ($Passed) {
        Write-Host "[PASS] $Label" -ForegroundColor Green
    }
    else {
        Write-Host "[FAIL] $Label" -ForegroundColor Red
        $script:FailureCount++
    }
}

# --------------------------------------------------
# 1. Kiem tra thu muc va cac file can co
# --------------------------------------------------

$RequiredFiles = @(
    "README.md",
    "00_INFO.md",
    "01_BaoCao\01_DacTaYeuCau.md",
    "07_QuanTriDuAn\01_KeHoachPhatTrien.md",
    "03_Database\schema-notes\01_KienTrucHeThong.md",
    "03_Database\schema-notes\02_MoHinhDuLieu.md",
    "03_Database\schema-notes\03_QuyTacKhongGian360.md",
    "03_Database\schema-notes\04_HopDongAPI.md",
    "05_KiemThu\PHAN_II_KiemTraThietKe.md"
)

foreach ($RelativePath in $RequiredFiles) {
    $FullPath = Join-Path $ProjectRoot $RelativePath

    $Exists = Test-Path -LiteralPath $FullPath -PathType Leaf
    Write-Result -Passed $Exists -Label "File ton tai: $RelativePath"

    if ($Exists) {
        $FileInfo = Get-Item -LiteralPath $FullPath

        $IsNotEmpty = $FileInfo.Length -gt 0
        Write-Result `
            -Passed $IsNotEmpty `
            -Label "File khong rong: $RelativePath"
    }
}

# --------------------------------------------------
# 2. Kiem tra cac file thiet ke co noi dung cot loi
# --------------------------------------------------

$ContentChecks = @(
    @{
        File = "03_Database\schema-notes\01_KienTrucHeThong.md"
        Pattern = "Frontend không kết nối trực tiếp đến MySQL"
        Label = "Kien truc ngan chan Frontend truy cap truc tiep MySQL"
    },
    @{
        File = "03_Database\schema-notes\01_KienTrucHeThong.md"
        Pattern = "Hostinger"
        Label = "Kien truc co nhac den Hostinger"
    },
    @{
        File = "03_Database\schema-notes\02_MoHinhDuLieu.md"
        Pattern = "viewpoints"
        Label = "Mo hinh co bang viewpoints"
    },
    @{
        File = "03_Database\schema-notes\02_MoHinhDuLieu.md"
        Pattern = "gateways"
        Label = "Mo hinh co bang gateways"
    },
    @{
        File = "03_Database\schema-notes\02_MoHinhDuLieu.md"
        Pattern = "hotspots"
        Label = "Mo hinh co bang hotspots"
    },
    @{
        File = "03_Database\schema-notes\02_MoHinhDuLieu.md"
        Pattern = "visit_events"
        Label = "Mo hinh co bang visit_events"
    },
    @{
        File = "03_Database\schema-notes\03_QuyTacKhongGian360.md"
        Pattern = "yaw_deg"
        Label = "Quy tac 360 co yaw_deg"
    },
    @{
        File = "03_Database\schema-notes\03_QuyTacKhongGian360.md"
        Pattern = "pitch_deg"
        Label = "Quy tac 360 co pitch_deg"
    },
    @{
        File = "03_Database\schema-notes\03_QuyTacKhongGian360.md"
        Pattern = "mini_map_x_norm"
        Label = "Quy tac 360 co toa do MiniMap"
    },
    @{
        File = "03_Database\schema-notes\04_HopDongAPI.md"
        Pattern = "/api/v1"
        Label = "Hop dong API co phien ban API"
    },
    @{
        File = "03_Database\schema-notes\04_HopDongAPI.md"
        Pattern = "/viewpoints/{viewpointId}/scene"
        Label = "Hop dong API co endpoint scene"
    },
    @{
        File = "03_Database\schema-notes\04_HopDongAPI.md"
        Pattern = "/visits/{publicId}/events"
        Label = "Hop dong API co endpoint ghi su kien"
    },
    @{
        File = "05_KiemThu\PHAN_II_KiemTraThietKe.md"
        Pattern = "Gateway"
        Label = "Checklist kiem thu co Gateway"
    }
)

foreach ($Check in $ContentChecks) {
    $FullPath = Join-Path $ProjectRoot $Check.File
    $Found = $false

    if (Test-Path -LiteralPath $FullPath -PathType Leaf) {
        $Found = Select-String `
    -LiteralPath $FullPath `
    -Encoding UTF8 `
    -SimpleMatch `
    -Pattern $Check.Pattern `
    -Quiet
    }

    Write-Result `
        -Passed $Found `
        -Label $Check.Label
}

# --------------------------------------------------
# 3. Kiem tra Git
# --------------------------------------------------

$GitDirectory = Join-Path $ProjectRoot ".git"
$HasGit = Test-Path -LiteralPath $GitDirectory -PathType Container

Write-Result -Passed $HasGit -Label "Git repository ton tai"

if ($HasGit) {
    $CurrentBranch = (
        git -C $ProjectRoot branch --show-current
    ).Trim()

    $BranchCommandSucceeded = $LASTEXITCODE -eq 0

    Write-Result `
        -Passed ($BranchCommandSucceeded -and $CurrentBranch -eq "dev") `
        -Label "Dang lam viec tren nhanh dev"

    $LocalBranches = @(
        git -C $ProjectRoot branch --format="%(refname:short)"
    )

    Write-Result `
        -Passed ($LocalBranches -contains "main") `
        -Label "Nhanh main ton tai"

    Write-Result `
        -Passed ($LocalBranches -contains "dev") `
        -Label "Nhanh dev ton tai"

    $RemoteNames = @(
        git -C $ProjectRoot remote
    )

    $RemoteIsConfigured = (
        $RemoteNames.Count -eq 1 -and
        $RemoteNames[0] -eq "origin"
    )

    Write-Result `
        -Passed $RemoteIsConfigured `
        -Label "Chi co remote origin trong repository"

    if ($RemoteIsConfigured) {
        $RemoteUrl = (
            git -C $ProjectRoot remote get-url origin
        ).Trim()

        $RemoteLooksLikeGitHub = $RemoteUrl -match `
            "^https://github\.com/[^/]+/[^/]+\.git$"

        Write-Result `
            -Passed $RemoteLooksLikeGitHub `
            -Label "Remote origin co dang URL GitHub HTTPS"
    }
}

# --------------------------------------------------
# 4. Tong ket
# --------------------------------------------------

Write-Host ""
Write-Host "==============================================" -ForegroundColor Cyan
Write-Host " KET QUA KIEM TRA" -ForegroundColor Cyan
Write-Host "==============================================" -ForegroundColor Cyan

if ($FailureCount -eq 0) {
    Write-Host "DAT: Khong co muc nao that bai." -ForegroundColor Green
    exit 0
}
else {
    Write-Host "CHUA DAT: Co $FailureCount muc can xu ly." `
        -ForegroundColor Red
    exit 1
}
