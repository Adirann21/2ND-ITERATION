"use client"

import Link from "next/link"
import { usePathname } from "next/navigation"

export function Header() {
  const pathname = usePathname()

  const navLinks = [
    { href: "/", label: "HOME" },
    { href: "/reserve", label: "RESERVE" },
    { href: "/calendar", label: "CALENDAR" },
    { href: "/about", label: "ABOUT US" },
    { href: "/contact", label: "CONTACT" },
  ]

  return (
    <header className="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
      <Link href="/" className="flex items-center">
        <div className="flex items-center border border-black px-2 py-1">
          <span className="text-xs font-medium tracking-wide">CAMPUS</span>
          <span className="bg-black text-white text-xs font-medium px-1 ml-1">RESERVE</span>
        </div>
      </Link>

      <nav className="hidden md:flex items-center gap-8">
        {navLinks.map((link) => (
          <Link
            key={link.href}
            href={link.href}
            className={`text-sm font-medium hover:text-gray-600 transition-colors ${
              pathname === link.href ? "text-black" : "text-gray-700"
            }`}
          >
            {link.label}
          </Link>
        ))}
      </nav>

      <div className="flex items-center gap-3">
        <Link
          href="/signup"
          className="px-4 py-1.5 text-sm font-medium bg-black text-white rounded-full hover:bg-gray-800 transition-colors"
        >
          Sign Up
        </Link>
        <Link
          href="/login"
          className="px-4 py-1.5 text-sm font-medium bg-black text-white rounded-full hover:bg-gray-800 transition-colors"
        >
          Log In
        </Link>
      </div>
    </header>
  )
}
