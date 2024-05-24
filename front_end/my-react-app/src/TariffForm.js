import React, { useState } from 'react';
import axios from 'axios'; 
import 'bootstrap/dist/css/bootstrap.min.css';


const TariffForm = () => {
  const [formData, setFormData] = useState({
    units: '',
    Tariff: 'LT-1A', 
    Purpose: 'Domestic', 
    BillingCycle: '2 months', 
    Phase: 'Single phase', 
  });
  const [totalCost, setTotalCost] = useState(null);
  const [error, setError] = useState(null);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
 
      const response = await axios.post('http://127.0.0.1:8000/api/student', formData);
      const { status, message, totalCost } = response.data;

      if (status === 200) {
        setTotalCost(totalCost);
        setError(null); 
      } else {
        setError(message); 
        setTotalCost(null); 
      }
    } catch (error) {
      console.error('Error:', error);
      setError('Error fetching data. Please try again.'); 
      setTotalCost(null); 
    }
  };

  return (
    <div className="container">
      <h1 className="mt-5 mb-4">Tariff Calculator</h1>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label htmlFor="units" className="form-label">Units:</label>
          <input type="number" id="units" className="form-control" name="units" value={formData.units} onChange={handleChange} required />
        </div>
        <div className="mb-3">
          <label htmlFor="Tariff" className="form-label">Tariff:</label>
          <select id="Tariff" className="form-select" name="Tariff" value={formData.Tariff} onChange={handleChange} required>
            <option value="LT-1A">LT-1A</option>
    
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="Purpose" className="form-label">Purpose:</label>
          <select id="Purpose" className="form-select" name="Purpose" value={formData.Purpose} onChange={handleChange} required>
            <option value="Domestic">Domestic</option>
     
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="BillingCycle" className="form-label">Billing Cycle:</label>
          <select id="BillingCycle" className="form-select" name="BillingCycle" value={formData.BillingCycle} onChange={handleChange} required>
            <option value="2 months">2 months</option>
     
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="Phase" className="form-label">Phase:</label>
          <select id="Phase" className="form-select" name="Phase" value={formData.Phase} onChange={handleChange} required>
            <option value="Single phase">Single phase</option>
         
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
      {totalCost !== null && (
        <div className="mt-4">
          <h2>Total Cost: {totalCost} Rs</h2>
        </div>
      )}
      {error && <div className="alert alert-danger mt-4">{error}</div>}
    </div>
  );
  
};

export default TariffForm;
