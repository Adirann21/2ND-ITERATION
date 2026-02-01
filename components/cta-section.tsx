import Link from "next/link"
import { Button } from "@/components/ui/button"

export function CTASection() {
  return (
    <section className="py-12 px-6 bg-white border-t border-gray-200">
      <div className="max-w-4xl mx-auto text-center">
        <p className="text-lg md:text-xl font-medium text-gray-900 mb-8 leading-relaxed">
          &ldquo;Ready to streamline your campus reservations? Sign up now
          <br className="hidden md:block" />
          and take control of your scheduling with Campus Reserve –
          <br className="hidden md:block" />
          efficient, reliable, and easy.&rdquo;
        </p>
        
        <div className="flex justify-center gap-4">
          <Button
            asChild
            className="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800"
          >
            <Link href="/signup">Sign Now!</Link>
          </Button>
          <Button
            asChild
            variant="outline"
            className="px-6 py-2 rounded-md border-gray-900 text-gray-900 hover:bg-gray-100 bg-transparent"
          >
            <Link href="/about">Learn More</Link>
          </Button>
        </div>
      </div>
    </section>
  )
}
