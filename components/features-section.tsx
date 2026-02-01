import Link from "next/link"
import { Button } from "@/components/ui/button"

const features = [
  {
    title: "Centralize reservations",
    description:
      "Bring all room and facility bookings into one platform. Campus Reserve eliminates scattered logs and manual coordination by providing a single, organized system for managing schedules.",
  },
  {
    title: "Streamline booking",
    description:
      "Make reservations fast and intuitive. With just a few clicks, students, faculty, and staff can book shared spaces without unnecessary steps or delays.",
  },
  {
    title: "Real-time availability",
    description:
      "View up-to-date availability through an integrated calendar. Users can instantly see open time slots, helping schools prevent double-bookings and scheduling conflicts.",
  },
  {
    title: "Improve administrative efficiency",
    description:
      "Reduce the workload on administrators by automating approvals, tracking reservations, and maintaining clear records. Campus Reserve helps schools save time while keeping operations organized and transparent.",
  },
]

export function FeaturesSection() {
  return (
    <section className="py-16 px-6 bg-white">
      <div className="max-w-6xl mx-auto">
        <h2 className="text-2xl md:text-3xl font-bold text-center text-gray-900 mb-12">
          With Campus Reserve You Can!
        </h2>

        <div className="grid md:grid-cols-2 gap-8 mb-12">
          {features.map((feature, index) => (
            <div key={index} className="flex gap-4">
              <div className="flex-shrink-0 w-6 h-6 border-2 border-gray-300 rounded" />
              <div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                  {feature.title}
                </h3>
                <p className="text-sm text-gray-600 leading-relaxed">
                  {feature.description}
                </p>
              </div>
            </div>
          ))}
        </div>

        <div className="flex justify-center gap-4">
          <Button
            asChild
            variant="outline"
            className="px-6 py-2 rounded-md border-gray-900 text-gray-900 hover:bg-gray-100 bg-transparent"
          >
            <Link href="/reserve">Reserve Now</Link>
          </Button>
          <Button
            asChild
            variant="outline"
            className="px-6 py-2 rounded-md border-gray-900 text-gray-900 hover:bg-gray-100 bg-transparent"
          >
            <Link href="/contact">Inquire Now</Link>
          </Button>
        </div>
      </div>
    </section>
  )
}
