// src/components/App.jsx

import React, { useState, useEffect } from "react";
import IncidentTable from "./IncidentTable";
import IncidentViewOnlyTable from "./IncidentViewOnlyTable";
import { supabase } from "../supabaseClient"; // Corrected path
import PropTypes from "prop-types";
import UserTable from "./UserTable"; // Ensure this path is correct

const App = () => {
    const [incidents, setIncidents] = useState([]);
    const [statuses, setStatuses] = useState([]);
    const [methods, setMethods] = useState([]);
    const [incidentTypes, setIncidentTypes] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [viewMode, setViewMode] = useState(true);
    const [showUserTable, setShowUserTable] = useState(false);
    const toggleUserTable = () => {
        setShowUserTable((prev) => !prev);
    };

    const [selectedCategory, setSelectedCategory] = useState("");
    const [selectedFilterValue, setSelectedFilterValue] = useState("");
    const [searchQuery, setSearchQuery] = useState("");
    const [filterStatus, setFilterStatus] = useState("");
    const [filterMethod, setFilterMethod] = useState("");
    const [filterIncidentType, setFilterIncidentType] = useState("");
    const [filterYear, setFilterYear] = useState("");
    const [filterMonth, setFilterMonth] = useState("");
    const [filterDay, setFilterDay] = useState("");

    const [uniqueYears, setUniqueYears] = useState([]);
    const [uniqueMonths, setUniqueMonths] = useState([]);
    const [uniqueDays, setUniqueDays] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            try {
                const { data: incidentData, error: incidentError } = await supabase
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
                        incident_suspect_name,
                        method:method_id(methodType)
                      )
                    `)
                    .order("date_reported", { ascending: false });

                if (incidentError) throw incidentError;
                setIncidents(incidentData);

                // Extract unique years, months, and days from the incident data
                const years = new Set();
                const months = new Set();
                const days = new Set();

                incidentData.forEach((incident) => {
                    const incidentDate = new Date(incident.date_reported);
                    years.add(incidentDate.getFullYear().toString());
                    months.add((incidentDate.getMonth() + 1).toString().padStart(2, "0"));
                    days.add(incidentDate.getDate().toString().padStart(2, "0"));
                });

                setUniqueYears([...years].sort((a, b) => b - a)); // Sort years descending
                setUniqueMonths([...months]);
                setUniqueDays([...days]);

                const { data: statusData, error: statusError } = await supabase
                    .from("status")
                    .select("status");

                if (statusError) throw statusError;
                setStatuses(statusData.map((s) => s.status));

                const { data: methodData, error: methodError } = await supabase
                    .from("method")
                    .select("methodType");

                if (methodError) throw methodError;
                setMethods(methodData.map((m) => m.methodType));

                const { data: incidentTypeData, error: incidentTypeError } = await supabase
                    .from("incident_type")
                    .select("incidentType");

                if (incidentTypeError) throw incidentTypeError;
                setIncidentTypes(incidentTypeData.map((it) => it.incidentType));
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    const applyFilter = (category, value) => {
        if (category === "Status") setFilterStatus(value);
        if (category === "Method") setFilterMethod(value);
        if (category === "Incident Type") setFilterIncidentType(value);
        if (category === "Year") setFilterYear(value);
        if (category === "Month") setFilterMonth(value);
        if (category === "Day") setFilterDay(value);
    };

    const filteredIncidents = incidents.filter((incident) => {
        const matchesSearch =
            searchQuery === "" ||
            incident.description.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.reporter_info?.incident_reporter_name?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.reporter_info?.incident_suspect_name?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.update_id?.toLowerCase().includes(searchQuery.toLowerCase())||
            incident.location?.toLowerCase().includes(searchQuery.toLowerCase())||
            incident.address?.toLowerCase().includes(searchQuery.toLowerCase());

        const matchesStatus = filterStatus === "" || (incident.incident_updates?.status?.status === filterStatus);
        const matchesMethod = filterMethod === "" || (incident.reporter_info?.method?.methodType === filterMethod);
        const matchesIncidentType = filterIncidentType === "" || (incident.incident_type?.incidentType === filterIncidentType);

        const incidentDate = new Date(incident.date_reported);
        const incidentYear = incidentDate.getFullYear().toString();
        const incidentMonth = (incidentDate.getMonth() + 1).toString().padStart(2, "0");
        const incidentDay = incidentDate.getDate().toString().padStart(2, "0");

        const matchesYear = filterYear === "" || incidentYear === filterYear;
        const matchesMonth = filterMonth === "" || incidentMonth === filterMonth;
        const matchesDay = filterDay === "" || incidentDay === filterDay;

        return matchesSearch && matchesStatus && matchesMethod && matchesIncidentType && matchesYear && matchesMonth && matchesDay;
    });

    if (loading) return <p>Loading incidents...</p>;
    if (error) return <p className="text-red-500">Error: {error}</p>;

    return (
        <div className="container mx-auto mt-8">
            <div className="flex justify-between items-center mb-4">
                <h1 className="text-3xl font-bold text-center text-white bg-gray-800 px-4 py-2 rounded-lg">
                    {showUserTable ? "Edit User Roles" : viewMode ? "View Incidents" : "Manage Incidents"}
                </h1>

                <div className="flex gap-2">
                    <button
                        onClick={toggleUserTable}
                        className="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md"
                    >
                        {showUserTable ? "Back to Incidents" : "Edit Users"}
                    </button>

                    {!showUserTable && (
                        <button
                            onClick={() => setViewMode(!viewMode)}
                            className="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md"
                        >
                            {viewMode ? "Switch to Edit Mode" : "Switch to View Mode"}
                        </button>
                    )}
                </div>
            </div>

            {!showUserTable && (
                <>
                    <div className="flex flex-nowrap gap-2 mb-4 overflow-x-auto">
                        <input
                            type="text"
                            placeholder="Search by reporter, reported name, tracking number, or location"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="p-2 border border-gray-300 rounded-md w-full mb-4"
                        />
                            
                        <select
                            value={selectedCategory}
                            onChange={(e) => {
                                setSelectedCategory(e.target.value);
                                setSelectedFilterValue("");
                            }}
                            className="p-2 border border-gray-300 rounded-md min-w-max pr-8 mb-4" 
                        >
                            <option value="">Select Filter Category</option>
                            <option value="Status">Status</option>
                            <option value="Method">Method</option>
                            <option value="Incident Type">Incident Type</option>
                            <option value="Year">Year</option>
                            <option value="Month">Month</option>
                            <option value="Day">Day</option>
                        </select>

                        {selectedCategory && (
                            <select
                                value={selectedFilterValue}
                                onChange={(e) => {
                                    setSelectedFilterValue(e.target.value);
                                    applyFilter(selectedCategory, e.target.value);
                                }}
                                className="p-2 border border-gray-300 rounded-md min-w-max pr-7 mb-4"
                            >
                                <option value="">Select {selectedCategory}</option>
                                {selectedCategory === "Status" && statuses.map((s) => <option key={s} value={s}>{s}</option>)}
                                {selectedCategory === "Method" && methods.map((m) => <option key={m} value={m}>{m}</option>)}
                                {selectedCategory === "Incident Type" && incidentTypes.map((t) => <option key={t} value={t}>{t}</option>)}
                                {selectedCategory === "Year" && uniqueYears.map((year) => (<option key={year} value={year}>{year}</option>))}
                                {selectedCategory === "Month" && uniqueMonths.map((month) => (<option key={month} value={month}>{month}</option>))}
                                {selectedCategory === "Day" && uniqueDays.map((day) => (<option key={day} value={day}>{day}</option>))}
                            </select>
                        )}
                    </div>
                </>
            )}

            {showUserTable ? <UserTable /> : viewMode ? <IncidentViewOnlyTable incidents={filteredIncidents} /> : <IncidentTable incidents={filteredIncidents} />}
        </div>
    );
};

export default App;
