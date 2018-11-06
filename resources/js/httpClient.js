import axios from 'axios';

export const API = axios.create({
  baseURL: `workshop/api/v1`,
});