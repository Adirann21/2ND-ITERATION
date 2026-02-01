const reasons = [
  {
    title: "Centralized Scheduling",
    description: "Manage all room and facility reservations in one organized platform.",
  },
  {
    title: "Real-Time Calendar Visibility",
    description: "Instantly view availability to prevent double-bookings and scheduling conflicts.",
  },
  {
    title: "Efficient Booking Process",
    description: "Reserve spaces quickly with an intuitive, step-by-step booking system.",
  },
  {
    title: "Reduced Administrative Workload",
    description: "Automate scheduling tasks and minimize manual coordination.",
  },
  {
    title: "Improved Space Utilization",
    description: "Gain better insight into how facilities are used and optimize resource allocation.",
  },
  {
    title: "Accessible Anytime, Anywhere",
    description: "Use the system through a web-based platform that supports flexible access.",
  },
  {
    title: "Reliable Third-Party Solution",
    description: "Operates independently, allowing schools to adopt the system without institutional dependency.",
  },
]

export function WhyChooseSection() {
  return (
    <section className="relative overflow-hidden">
      {/* Gradient background */}
      <div className="absolute inset-0 bg-gradient-to-br from-purple-200 via-pink-100 to-cyan-200 opacity-50" />
      
      <div className="relative max-w-6xl mx-auto px-6 py-16">
        <div className="flex flex-col md:flex-row gap-12 items-start">
          <div className="md:w-1/2">
            <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-8">
              Why Choose Campus Reserve?
            </h2>
            
            <ul className="space-y-4">
              {reasons.map((reason, index) => (
                <li key={index} className="flex items-start gap-2">
                  <span className="text-gray-700 mt-1">•</span>
                  <div>
                    <span className="font-semibold text-gray-900">{reason.title}</span>
                    <br />
                    <span className="text-sm text-gray-600">{reason.description}</span>
                  </div>
                </li>
              ))}
            </ul>
          </div>
          
          <div className="md:w-1/2 flex justify-center items-center">
            {/* School building illustration */}
            <svg viewBox="0 0 300 250" className="w-72 h-64">
              {/* Main building */}
              <rect x="80" y="100" width="140" height="120" fill="#e8d4b8" stroke="#c4a77d" strokeWidth="2"/>
              
              {/* Roof */}
              <polygon points="150,40 60,100 240,100" fill="#8b4513" stroke="#6b3410" strokeWidth="2"/>
              
              {/* Clock/bell tower */}
              <rect x="130" y="50" width="40" height="50" fill="#e8d4b8" stroke="#c4a77d" strokeWidth="2"/>
              <polygon points="150,30 125,50 175,50" fill="#8b4513"/>
              <circle cx="150" cy="70" r="12" fill="white" stroke="#333"/>
              <line x1="150" y1="70" x2="150" y2="62" stroke="#333" strokeWidth="2"/>
              <line x1="150" y1="70" x2="156" y2="70" stroke="#333" strokeWidth="2"/>
              
              {/* Windows - top row */}
              <rect x="95" y="115" width="25" height="30" fill="#87ceeb" stroke="#333"/>
              <rect x="137" y="115" width="25" height="30" fill="#87ceeb" stroke="#333"/>
              <rect x="180" y="115" width="25" height="30" fill="#87ceeb" stroke="#333"/>
              
              {/* Door */}
              <rect x="130" y="165" width="40" height="55" fill="#6b3410" stroke="#4a2409" strokeWidth="2"/>
              <circle cx="160" cy="195" r="3" fill="#f4d03f"/>
              
              {/* Windows - beside door */}
              <rect x="95" y="165" width="25" height="30" fill="#87ceeb" stroke="#333"/>
              <rect x="180" y="165" width="25" height="30" fill="#87ceeb" stroke="#333"/>
              
              {/* Steps */}
              <rect x="120" y="220" width="60" height="8" fill="#c4a77d"/>
              <rect x="115" y="228" width="70" height="8" fill="#b09060"/>
              
              {/* Flag */}
              <line x1="150" y1="10" x2="150" y2="30" stroke="#333" strokeWidth="2"/>
              <polygon points="150,10 175,17 150,24" fill="#e74c3c"/>
              
              {/* Trees */}
              <circle cx="40" cy="180" r="25" fill="#228b22"/>
              <rect x="35" y="200" width="10" height="20" fill="#8b4513"/>
              
              <circle cx="260" cy="180" r="25" fill="#228b22"/>
              <rect x="255" y="200" width="10" height="20" fill="#8b4513"/>
              
              {/* Ground */}
              <rect x="0" y="236" width="300" height="14" fill="#90ee90"/>
            </svg>
          </div>
        </div>
      </div>
    </section>
  )
}
