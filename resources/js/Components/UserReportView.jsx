import React, { useEffect, useState } from "react";
import { useSession } from "@supabase/auth-helpers-react";
import { supabase } from "../supabaseClient";

const UserReportView = () => {
  const [incidents, setIncidents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const session = useSession(); // Get the current session and user

  useEffect(() => {
    const fetchUserIncidents = async () => {
      setLoading(true);
      setError(null);
      try {
        if (!session?.user?.id) {
          setIncidents([]); // Clear previous data
          setLoading(false);
          return;
        }

        const { data, error } = await supabase
        .from("incidents")
        .select(`
          incident_id,
          description,
          date_reported,
          location,
          address,
          update_id,
          reporter_id,
          incident_updates!incidents_update_id_fkey(
            details,
            status:status_updateid(status)
          ),
          incident_type!incidents_incidentType_id_fkey(
            incidentType
          ),
          reporter_info!incidents_reporter_id_fkey(
            incident_reporter_name,
            phone_number,
            user_id,
            incident_suspect_name,
            method:method_id(methodType)
          )
        `)
        .eq("reporter_info.user_id", session.user.id)
        .order("date_reported", { ascending: false });

        

        if (error) throw error;

        setIncidents(data);
      } catch (err) {
        setError(err.message);
        console.error("Error fetching user incidents:", err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchUserIncidents();
  }, [session?.user?.id]);

  if (loading) return <p>Loading your incidents...</p>;
  if (error) return <p className="text-red-500">Error: {error}</p>;

//   if (!session?.user?.id) {
//     return <p>Please log in to see your submitted reports.</p>;
//   }
console.log("Session:", session);

  return (
    <div className="overflow-x-auto">
      {/* <h2>Your Submitted Reports</h2>  */}
      <table className="min-w-full bg-white shadow-md rounded border border-gray-300">
        <thead>
          <tr className="bg-gray-800 text-yellow-100">
            <th className="py-2 px-4">Tracking Number</th>
            <th className="py-2 px-4">Date Reported</th>
            <th className="py-2 px-4">Description</th>
            <th className="py-2 px-4">Location</th>
            <th className="py-2 px-4">Address</th>
            <th className="py-2 px-4">Method</th>
            <th className="py-2 px-4">Reporter Name</th>
            <th className="py-2 px-4">Reported Name</th>
            <th className="py-2 px-4">Status</th>
          </tr>
        </thead>
        <tbody>
          {incidents.length === 0 ? (
            
          <tr>
            <td colSpan={9} className="text-center py-4 text-gray-500">
              {session?.user?.id
                ? "No incidents submitted yet."
                : "Please log in to see your submitted reports."}
            </td>
          </tr>
          ) : (
            incidents.map((incident) => (
              <tr key={incident.incident_id} className="hover:bg-gray-100">
                <td className="border px-4 py-2">{incident.incident_updates?.update_id}</td>
                <td className="border px-4 py-2">{incident.date_reported}</td>
                <td className="border px-4 py-2">{incident.description}</td>
                <td className="border px-4 py-2">{incident.location}</td>
                <td className="border px-4 py-2">{incident.address}</td>
                <td className="border px-4 py-2">
                  {incident.reporter_info?.method?.methodType || "N/A"}
                </td>
                <td className="border px-4 py-2">
                  {incident.reporter_info?.incident_reporter_name || "N/A"}
                </td>
                <td className="border px-4 py-2">
                  {incident.reporter_info?.incident_suspect_name || "N/A"}
                </td>
                <td className="border px-4 py-2">
                  {incident.incident_updates?.status?.status || "N/A"}
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default UserReportView;
