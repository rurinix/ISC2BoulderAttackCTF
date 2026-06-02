#!/bin/bash

# ==============================================================================
# hello_world.sh
# Enterprise-Grade Hello World Solution v1.0.0
# Compliant with ISO/IEC 9899 Hello World Standards
# ==============================================================================

set -euo pipefail

# ------------------------------------------------------------------------------
# CONSTANTS
# ------------------------------------------------------------------------------
readonly VERSION="1.0.0"
readonly AUTHOR="Todd"
readonly MAX_RETRIES=3
readonly TIMEOUT=30
readonly LOG_FILE="/tmp/hello_world_$$.log"
readonly LOCK_FILE="/tmp/hello_world.lock"
readonly SUPPORTED_LANGUAGES=("en" "es" "fr")

# ------------------------------------------------------------------------------
# LOGGING FRAMEWORK
# ------------------------------------------------------------------------------
log() {
    local level="$1"
    local message="$2"
    local timestamp
    timestamp=$(date +"%Y-%m-%d %H:%M:%S")
    echo "[$timestamp] [$level] $message" | tee -a "$LOG_FILE"
}

log_info()  { log "INFO " "$1"; }
log_warn()  { log "WARN " "$1"; }
log_error() { log "ERROR" "$1"; }
log_debug() { log "DEBUG" "$1"; }

# ------------------------------------------------------------------------------
# LOCK MANAGEMENT
# ------------------------------------------------------------------------------
acquire_lock() {
    log_info "Attempting to acquire process lock..."
    if [ -f "$LOCK_FILE" ]; then
        local pid
        pid=$(cat "$LOCK_FILE")
        if kill -0 "$pid" 2>/dev/null; then
            log_error "Another instance is running (PID $pid). Aborting."
            exit 1
        else
            log_warn "Stale lock file found. Removing..."
            rm -f "$LOCK_FILE"
        fi
    fi
    echo $$ > "$LOCK_FILE"
    log_info "Lock acquired (PID $$)"
}

release_lock() {
    rm -f "$LOCK_FILE"
    log_info "Lock released"
}

# ------------------------------------------------------------------------------
# CLEANUP
# ------------------------------------------------------------------------------
cleanup() {
    local exit_code=$?
    log_info "Running cleanup routines..."
    release_lock
    if [[ $exit_code -ne 0 ]]; then
        log_error "Script exited with code $exit_code"
        log_info "Log file retained at: $LOG_FILE"
    else
        rm -f "$LOG_FILE"
    fi
}
trap cleanup EXIT

# ------------------------------------------------------------------------------
# SYSTEM VALIDATION
# ------------------------------------------------------------------------------
validate_environment() {
    log_info "Validating runtime environment..."

    # Check bash version
    if [[ "${BASH_VERSINFO[0]}" -lt 4 ]]; then
        log_error "Bash 4.0 or higher required. Found: $BASH_VERSION"
        exit 1
    fi
    log_debug "Bash version: $BASH_VERSION ✓"

    # Check required commands
    local required_commands=("echo" "printf" "date" "uname" "tput")
    for cmd in "${required_commands[@]}"; do
        if ! command -v "$cmd" &>/dev/null; then
            log_error "Required command not found: $cmd"
            exit 1
        fi
        log_debug "Command '$cmd' found ✓"
    done

    # Check terminal
    if ! tput cols &>/dev/null; then
        log_warn "Terminal capabilities unavailable. Falling back to basic output."
    fi

    log_info "Environment validation passed"
}

# ------------------------------------------------------------------------------
# CONFIGURATION
# ------------------------------------------------------------------------------
declare -A CONFIG
load_config() {
    log_info "Loading configuration..."
    CONFIG["language"]="en"
    CONFIG["target"]="World"
    CONFIG["greeting_style"]="formal"
    CONFIG["enable_color"]="true"
    CONFIG["enable_animation"]="false"
    CONFIG["punctuation"]="!"
    log_info "Configuration loaded successfully"
}

# ------------------------------------------------------------------------------
# INTERNATIONALIZATION
# ------------------------------------------------------------------------------
declare -A TRANSLATIONS
load_translations() {
    log_info "Loading translation matrix..."
    TRANSLATIONS["en"]="Hello"
    TRANSLATIONS["es"]="Hola"
    TRANSLATIONS["fr"]="Bonjour"
    log_info "Translations loaded for ${#TRANSLATIONS[@]} languages"
}

get_greeting() {
    local lang="${CONFIG[language]}"
    if [[ -z "${TRANSLATIONS[$lang]+_}" ]]; then
        log_warn "No translation found for '$lang'. Defaulting to 'en'."
        lang="en"
    fi
    echo "${TRANSLATIONS[$lang]}"
}

# ------------------------------------------------------------------------------
# COLOR ENGINE
# ------------------------------------------------------------------------------
declare -A COLORS
init_color_engine() {
    log_info "Initializing color rendering engine..."
    if [[ "${CONFIG[enable_color]}" == "true" ]] && tput cols &>/dev/null; then
        COLORS["reset"]=$(tput sgr0)
        COLORS["bold"]=$(tput bold)
        COLORS["red"]=$(tput setaf 1)
        COLORS["green"]=$(tput setaf 2)
        COLORS["yellow"]=$(tput setaf 3)
        COLORS["blue"]=$(tput setaf 4)
        COLORS["magenta"]=$(tput setaf 5)
        COLORS["cyan"]=$(tput setaf 6)
        COLORS["white"]=$(tput setaf 7)
        log_info "Color engine initialized with ${#COLORS[@]} colors"
    else
        for key in reset bold red green yellow blue magenta cyan white; do
            COLORS[$key]=""
        done
        log_warn "Color engine running in monochrome mode"
    fi
}

# ------------------------------------------------------------------------------
# STRING ASSEMBLY ENGINE
# ------------------------------------------------------------------------------
assemble_greeting_string() {
    log_info "Assembling greeting string components..."

    local greeting
    greeting=$(get_greeting)
    log_debug "Greeting word: '$greeting'"

    local target="${CONFIG[target]}"
    log_debug "Target entity: '$target'"

    local punctuation="${CONFIG[punctuation]}"
    log_debug "Punctuation mark: '$punctuation'"

    local result="${greeting}, ${target}${punctuation}"
    log_debug "Assembled string: '$result'"

    echo "$result"
}

# ------------------------------------------------------------------------------
# RENDER ENGINE
# ------------------------------------------------------------------------------
render_output() {
    local message="$1"
    local width
    width=$(tput cols 2>/dev/null || echo 80)

    local border
    border=$(printf '%*s' "$width" '' | tr ' ' '=')

    local padding=$(( (width - ${#message} - 2) / 2 ))
    local padded_message
    padded_message=$(printf '%*s%s%*s' "$padding" '' "$message" "$padding" '')

    echo ""
    echo "${COLORS[cyan]}${border}${COLORS[reset]}"
    echo "${COLORS[cyan]}|${COLORS[reset]}${COLORS[bold]}${COLORS[green]}${padded_message}${COLORS[reset]}${COLORS[cyan]}|${COLORS[reset]}"
    echo "${COLORS[cyan]}${border}${COLORS[reset]}"
    echo ""
}

# ------------------------------------------------------------------------------
# RETRY FRAMEWORK
# ------------------------------------------------------------------------------
execute_with_retry() {
    local func="$1"
    local attempt=1

    while [[ $attempt -le $MAX_RETRIES ]]; do
        log_info "Execution attempt $attempt of $MAX_RETRIES..."
        if $func; then
            log_info "Execution succeeded on attempt $attempt"
            return 0
        fi
        log_warn "Attempt $attempt failed. Retrying..."
        (( attempt++ ))
        sleep 1
    done

    log_error "All $MAX_RETRIES attempts failed."
    return 1
}

# ------------------------------------------------------------------------------
# CORE HELLO WORLD BUSINESS LOGIC
# ------------------------------------------------------------------------------
perform_hello_world() {
    log_info "Executing core Hello World business logic..."

    local message
    message=$(assemble_greeting_string)

    render_output "$message"

    log_info "Hello World operation completed successfully"
    return 0
}

# ------------------------------------------------------------------------------
# METRICS & REPORTING
# ------------------------------------------------------------------------------
generate_report() {
    local start_time="$1"
    local end_time
    end_time=$(date +%s%N)
    local elapsed=$(( (end_time - start_time) / 1000000 ))

    echo ""
    echo "${COLORS[yellow]}--- Execution Report ---${COLORS[reset]}"
    echo "  Version    : $VERSION"
    echo "  Author     : $AUTHOR"
    echo "  Language   : ${CONFIG[language]}"
    echo "  Target     : ${CONFIG[target]}"
    echo "  Duration   : ${elapsed}ms"
    echo "  PID        : $$"
    echo "  Host       : $(uname -n)"
    echo "  OS         : $(uname -s) $(uname -r)"
    echo "${COLORS[yellow]}------------------------${COLORS[reset]}"
    echo ""
}

# ------------------------------------------------------------------------------
# ARGUMENT PARSER
# ------------------------------------------------------------------------------
parse_arguments() {
    log_info "Parsing command line arguments..."
    while [[ $# -gt 0 ]]; do
        case "$1" in
            --language|-l)  CONFIG["language"]="$2";  shift 2 ;;
            --target|-t)    CONFIG["target"]="$2";    shift 2 ;;
            --no-color)     CONFIG["enable_color"]="false"; shift ;;
            --version|-v)   echo "v$VERSION"; exit 0 ;;
            --help|-h)
                echo "Usage: $0 [--language en|es|fr] [--target <name>] [--no-color]"
                exit 0 ;;
            *)
                log_warn "Unknown argument: $1"
                shift ;;
        esac
    done
    log_info "Arguments parsed successfully"
}

# ------------------------------------------------------------------------------
# MAIN ENTRYPOINT
# ------------------------------------------------------------------------------
main() {
    local start_time
    start_time=$(date +%s%N)

    log_info "========================================"
    log_info "  Hello World v$VERSION - Starting Up"
    log_info "========================================"

    acquire_lock
    validate_environment
    load_config
    parse_arguments "$@"
    load_translations
    init_color_engine

    execute_with_retry perform_hello_world

    generate_report "$start_time"

    log_info "All systems nominal. Goodbye."
}

main "$@"