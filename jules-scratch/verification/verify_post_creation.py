from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch() # Removed headless=False
    context = browser.new_context()
    page = context.new_page()
    page.goto("http://localhost:8000/login")
    page.fill('input[name="email"]', "test@example.com")
    page.fill('input[name="password"]', "password")
    page.click('button[type="submit"]')
    page.wait_for_url("http://localhost:8000/dashboard")
    page.goto("http://localhost:8000/posts/create")
    page.fill('input[name="title"]', "My Test Post")
    page.fill('textarea[name="body"]', "This is a test post.")
    page.click('button[type="submit"]')
    page.wait_for_url("http://localhost:8000/posts")
    page.screenshot(path="jules-scratch/verification/post_creation.png")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)