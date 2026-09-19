require "html-proofer"

desc "Clean up generated site"
task :clean do
  sh "rm -rf _site"
end

desc "Build the site with the same Jekyll GitHub Pages uses"
task :build do
  sh "bundle exec jekyll build"
end

desc "Build, then check internal links and images on the hand-maintained pages"
task :test => :build do
  HTMLProofer.check_directory(
    "./_site",
    disable_external: true,   # external links are not ours to keep alive
    enforce_https: false,
    ignore_missing_alt: true,
    allow_missing_href: true, # legacy <a name="..."> anchors
    # The 2007-2011 posts imported from WordPress are historical; do not gate on them.
    ignore_files: [%r{_site/blog/index\.php/}, %r{_site/javascript/}]
  ).run
end

task default: :build
