import React from "react";
import { useEffect, useState } from "react";
import { supabase } from "../supabaseClient";

const IncidentTable = () => {
  const [incidents, setIncidents] = useState([]);

  useEffect(() => {
    const fetchIncidents = async () => {
        console.log("Fetching incidents...");

        const { data, error } = await supabase.from("incidents").select("*");

        if (error) {
            console.error("Error fetching incidents:", error.message);
        } else {
            console.log("Fetched incidents:", data);
            setIncidents(data);
        }
    };

    fetchIncidents();
}, []);

  const fetchIncidents = async () => {
    let { data, error } = await supabase.from("incidents").select("*");
    if (error) {
      console.error("Error fetching data:", error);
    } else {
      setIncidents(data);
    }
  };

  return (
    <table className="min-w-full bg-white shadow-md rounded">
      <thead>
        <tr>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">ID</th>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">Reporter ID</th>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">Description</th>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">Date Reported</th>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">Location</th>
          <th className="py-2 px-4 bg-gray-800 text-yellow-100">Actions</th>
        </tr>
      </thead>
      <tbody>
        {incidents.map((incident) => (
          <tr key={incident.incident_id} className="hover:bg-gray-100">
            <td className="border px-4 py-2">{incident.incident_id}</td>
            <td className="border px-4 py-2">{incident.reporter_id}</td>
            <td className="border px-4 py-2">{incident.description}</td>
            <td className="border px-4 py-2">{incident.date_reported}</td>
            <td className="border px-4 py-2">{incident.location}</td>
            <td className="border px-4 py-2">
              <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                Edit
              </button>
              <button className="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-2">
                Delete
              </button>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
};

export default IncidentTable;
