import React from "react";
import { supabase } from "../supabaseClient"; // Ensure Supabase is correctly configured

const IncidentViewOnlyTable = ({ incidents }) => {
  return (
    <div>
      <table className="min-w-full bg-white shadow-md rounded border border-gray-300 mt-4">
        <thead>
          <tr className="bg-gray-800 text-yellow-100 text-sm md:text-base">
            <th className="py-2 px-4">Tracking #</th>
            <th className="py-2 px-4">Method</th>
            <th className="py-2 px-4">Incident Type</th>
            <th className="py-2 px-4">Date Reported</th>
            <th className="py-2 px-4">Reporter</th>
            <th className="py-2 px-4">Reported</th>
            <th className="py-2 px-4">Incident Details</th>
            <th className="py-2 px-4">Subdivision</th>
            <th className="py-2 px-4">Address</th>
            <th className="py-2 px-4">Status</th>
            <th className="py-2 px-4">Description</th>
          </tr>
        </thead>
        <tbody>
          {incidents.length === 0 ? (
            <tr>
              <td colSpan="7" className="text-center py-4 text-gray-500"> 
                No incidents found
              </td>
            </tr>
          ) : (
            incidents.map((incident) => (
              <tr key={incident.incident_id} className="hover:bg-gray-100 text-sm md:text-base">
                <td className="border px-4 py-2">{incident.update_id}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.method?.methodType || "N/A"}</td>
                <td className="border px-4 py-2">{incident.incident_type?.incidentType}</td>
                <td className="border px-4 py-2">{new Date(incident.date_reported).toLocaleString()}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.incident_reporter_name || "N/A"}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.incident_suspect_name || "N/A"}</td>
                <td className="border px-4 py-2">{incident.description}</td>
                <td className="border px-4 py-2">{incident.location}</td>
                <td className="border px-4 py-2">{incident.address}</td>
                <td className="border px-4 py-2">{incident.incident_updates?.status?.status || "N/A"}</td>
                <td className="border px-4 py-2">{incident.incident_updates?.details|| "N/A"}</td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default IncidentViewOnlyTable;
